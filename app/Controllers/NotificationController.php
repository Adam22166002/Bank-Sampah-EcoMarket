<?php

namespace App\Controllers;

use App\Models\NotifikasiModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Myth\Auth\Models\UserModel;

class NotificationController extends ResourceController
{
    use ResponseTrait;
    
    protected $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    protected $userModel;
    protected $notifikasiModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->notifikasiModel = new NotifikasiModel();
        
        if (!getenv('FIREBASE_SERVER_KEY')) {
            log_message('error', 'FIREBASE_SERVER_KEY tidak ditemukan di environment');
        }
    }

    public function saveToken()
    {
        try {
            if (!$this->request->getJSON() || !property_exists($this->request->getJSON(), 'token')) {
                return $this->failValidationError('Token tidak valid');
            }

            $token = $this->request->getJSON()->token;
            $userId = user()->id;

            if (empty($token) || strlen($token) < 50) {
                return $this->failValidationError('Token FCM tidak valid');
            }

            $data = [
                'user_id' => $userId,
                'fcm_token' => $token,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $existingToken = $this->notifikasiModel->where('user_id', $userId)->first();
            
            if ($existingToken) {
                $this->notifikasiModel->update($existingToken['id'], $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->notifikasiModel->insert($data);
            }

            return $this->respond(['success' => true, 'message' => 'Token berhasil disimpan']);
            
        } catch (\Exception $e) {
            log_message('error', '[NotificationController::saveToken] ' . $e->getMessage());
            return $this->failServerError('Gagal menyimpan token: ' . $e->getMessage());
        }
    }

    protected function sendFCM($to, $title, $body, $data = [])
    {
        try {
            if (empty($to)) {
                log_message('warning', 'Attempted to send notification with empty token');
                return false;
            }

            $message = [
                'to' => $to,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'icon' => '/Assets/img/icons/icon-192x192.png',
                    'click_action' => site_url()
                ],
                'data' => array_merge($data, [
                    'timestamp' => time()
                ])
            ];

            $headers = [
                'Authorization: key=' . getenv('FIREBASE_SERVER_KEY'),
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

            $result = curl_exec($ch);
            
            if ($result === false) {
                throw new \Exception('Curl error: ' . curl_error($ch));
            }
            
            $response = json_decode($result, true);
            
            if (isset($response['failure']) && $response['failure'] > 0) {
                // Token mungkin tidak valid, hapus dari database
                $this->notifikasiModel->where('fcm_token', $to)->delete();
                log_message('warning', 'FCM token invalid, deleted from database');
                return false;
            }

            curl_close($ch);
            return true;

        } catch (\Exception $e) {
            log_message('error', '[NotificationController::sendFCM] ' . $e->getMessage());
            return false;
        }
    }

    public function notifyNewTransaction($transactionData)
    {
        if (empty($transactionData)) return false;

        try {
            $adminUsers = $this->userModel->getUsersByRole('admin');
            foreach ($adminUsers as $admin) {
                $token = $this->notifikasiModel->where('user_id', $admin->id)->first();
                if (empty($token)) continue;

                $this->sendFCM(
                    $token['fcm_token'],
                    'Transaksi Sampah Baru',
                    "Transaksi baru dari {$transactionData['username']} - {$transactionData['berat_sampah']} kg",
                    [
                        'type' => 'new_transaction',
                        'transaction_id' => $transactionData['id'],
                        'url' => site_url('admin/transaksi')
                    ]
                );
            }
            return true;
        } catch (\Exception $e) {
            log_message('error', '[NotificationController::notifyNewTransaction] ' . $e->getMessage());
            return false;
        }
    }

    public function sendStatusChangeNotification($userId, $status, $type, $data = [])
    {
        try {
            $token = $this->notifikasiModel->where('user_id', $userId)->first();
            if (!$token) return false;

            $notificationData = $this->prepareStatusNotification($status, $type, $data);
            if (!$notificationData) return false;

            return $this->sendFCM(
                $token['fcm_token'],
                $notificationData['title'],
                $notificationData['body'],
                $notificationData['data']
            );

        } catch (\Exception $e) {
            log_message('error', '[NotificationController::sendStatusChangeNotification] ' . $e->getMessage());
            return false;
        }
    }

    protected function prepareStatusNotification($status, $type, $data)
    {
        $title = '';
        $body = '';
        $extraData = [];

        switch ($type) {
            case 'transaction':
                $title = 'Status Transaksi Sampah';
                $body = "Transaksi sampah Anda telah " . ($status === 'approved' ? 'disetujui' : 'ditolak');
                if ($status === 'approved' && isset($data['point_sampah_dijual'])) {
                    $body .= ". Point yang didapat: {$data['point_sampah_dijual']}";
                }
                $extraData['url'] = site_url('user/riwayatTransaksi');
                break;

            case 'product':
                $title = 'Status Produk UMKM';
                $body = isset($data['nama_produk']) ? 
                    "Produk {$data['nama_produk']} telah " . ($status === 'approved' ? 'disetujui' : 'ditolak') :
                    "Status produk telah diperbarui";
                $extraData['url'] = site_url('seller/produk');
                break;

            case 'withdrawal':
                $title = 'Status Penarikan';
                $body = "Penarikan point Anda telah " . ($status === 'approved' ? 'disetujui' : 'ditolak');
                if ($status === 'approved' && isset($data['amount'])) {
                    $body .= ". Jumlah: {$data['amount']}";
                }
                $extraData['url'] = site_url('riwayat/point');
                break;

            default:
                return null;
        }

        return [
            'title' => $title,
            'body' => $body,
            'data' => array_merge([
                'type' => $type . '_status',
                'status' => $status,
                'id' => $data['id'] ?? null,
            ], $extraData)
        ];
    }
    public function sendNewProductNotification($productData)
{
    try {
        $nasabahUsers = $this->userModel->getUsersByRole('nasabah');
        
        foreach ($nasabahUsers as $nasabah) {
            $token = $this->notifikasiModel->where('user_id', $nasabah->id)->first();
            if (!$token) continue;

            // Kirim notification
            $this->sendFCM(
                $token['fcm_token'],
                'Produk UMKM Baru!',
                "Produk baru: {$productData['nama_produk']} - {$productData['harga_point']} point",
                [
                    'type' => 'new_product',
                    'product_id' => $productData['id'],
                    'url' => site_url('tukar-produk')
                ]
            );

            // notifikasi ke database
            $this->notifikasiModel->insert([
                'user_id' => $nasabah->id,
                'judul' => 'Produk UMKM Baru',
                'pesan' => "Produk baru telah ditambahkan: {$productData['nama_produk']} dengan harga {$productData['harga_point']} point",
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return true;
    } catch (\Exception $e) {
        log_message('error', '[NotificationController::sendNewProductNotification] ' . $e->getMessage());
        return false;
    }
}
public function sendNotification($target, $title, $body, $data = [])
    {
        try {
            // Jika target adalah role
            if (is_string($target)) {
                $users = $this->userModel->getUsersByRole($target);
                foreach ($users as $user) {
                    $this->sendNotificationToUser($user->id, $title, $body, $data);
                }
            } 
            // Jika target adalah user_id
            else {
                $this->sendNotificationToUser($target, $title, $body, $data);
            }

            return true;
        } catch (\Exception $e) {
            log_message('error', '[NotificationController::sendNotification] ' . $e->getMessage());
            return false;
        }
    }
    private function sendNotificationToUser($userId, $title, $body, $data = [])
    {
        try {
            // Ambil token FCM user
            $token = $this->notifikasiModel->where('user_id', $userId)->first();
            if (!$token) return false;

            // Kirim notifikasi push
            $this->sendFCM(
                $token['fcm_token'],
                $title,
                $body,
                $data
            );

            // Simpan ke database
            $this->notifikasiModel->insert([
                'user_id' => $userId,
                'judul' => $title,
                'pesan' => $body,
                'data' => json_encode($data),
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return true;
        } catch (\Exception $e) {
            log_message('error', '[NotificationController::sendNotificationToUser] ' . $e->getMessage());
            return false;
        }
    }

}