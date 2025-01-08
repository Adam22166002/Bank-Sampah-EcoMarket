<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use Myth\Auth\Models\UserModel;

class ProdukController extends BaseController
{
    protected $produkModel;
    protected $db;
    protected $userModel;
    protected $notificationController;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->userModel = new UserModel();
        $this->notificationController = new NotificationController();
        $this->db = \Config\Database::connect();
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
            'validation' => \Config\Services::validation()
        ];
        

        return view('seller/produk/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_produk' => 'required|min_length[3]',
            'deskripsi' => 'required',
            'harga_produk' => 'required|numeric|greater_than[0]',
            'stok' => 'required|numeric|greater_than[0]',
            'foto_produk' => [
                'rules' => 'uploaded[foto_produk]|is_image[foto_produk]|mime_in[foto_produk,image/jpg,image/jpeg,image/png]|max_size[foto_produk,2048]',
                'errors' => [
                    'uploaded' => 'Pilih foto produk',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                    'max_size' => 'Ukuran gambar terlalu besar (max 2MB)'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $this->db->transStart();

            $foto = $this->request->getFile('foto_produk');
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/fotoProduk', $namaFoto);

            $data = [
                'user_id' => user()->id,
                'nama_produk' => $this->request->getPost('nama_produk'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'harga_produk' => $this->request->getPost('harga_produk'),
                'stok' => $this->request->getPost('stok'),
                'foto_produk' => $namaFoto,
                'status' => 'pending',
                'terjual' => 0
            ];

            $productId = $this->produkModel->insert($data, true);

            if ($productId) {
                $productData = [
                    'id' => $productId,
                    'nama_produk' => $data['nama_produk'],
                    'harga_point' => $data['harga_produk'],
                    'deskripsi' => $data['deskripsi']
                ];

                // notifikasi ke admin
                $this->notificationController->sendNotification(
                    'admin',
                    'Produk Baru Menunggu Verifikasi',
                    "Produk baru: {$data['nama_produk']} perlu diverifikasi",
                    [
                        'type' => 'new_product_verification',
                        'product_id' => $productId
                    ]
                );
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Gagal menyimpan produk');
            }

            return redirect()->to('/seller')->with('message', 'Penambahan Produk Berhasil, Silahkan Menunggu Verifikasi');

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', '[ProdukController::store] ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    public function verifikasiProduk($id, $status)
    {
        try {
            $produk = $this->produkModel->find($id);
            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan');
            }

            $this->db->transStart();

            //update status produk
            $this->produkModel->update($id, [
                'status' => $status,
                'admin_verifikasi_id' => user()->id,
                'tanggal_verifikasi' => date('Y-m-d H:i:s')
            ]);

            //notifikasi ke seller
            $this->notificationController->sendStatusChangeNotification(
                $produk['user_id'],
                $status,
                'product',
                [
                    'id' => $id,
                    'nama_produk' => $produk['nama_produk']
                ]
            );

            //notifikasi ke nasabah
            if ($status === 'approved') {
                $this->notificationController->sendNewProductNotification([
                    'id' => $id,
                    'nama_produk' => $produk['nama_produk'],
                    'harga_point' => $produk['harga_produk']
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Gagal memproses verifikasi');
            }

            return redirect()->back()->with('message', 'Status produk berhasil diupdate');

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', '[ProdukController::verifikasiProduk] ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Produk',
            'produk' => $this->produkModel->where('user_id', user()->id)->find($id),
            'validation' => \Config\Services::validation()
        ];

        if (empty($data['produk'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        return view('seller/produk/edit', $data);
    }

    public function update($id)
    {

        $rules = [
            'nama_produk' => 'required|min_length[3]',
            'deskripsi' => 'required',
            'harga_produk' => 'required|numeric|greater_than[0]',
            'stok' => 'required|numeric|greater_than[0]'
        ];


        if ($this->request->getFile('foto_produk')->isValid()) {
            $rules['foto_produk'] = [
                'rules' => 'is_image[foto_produk]|mime_in[foto_produk,image/jpg,image/jpeg,image/png]|max_size[foto_produk,2048]',
                'errors' => [
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                    'max_size' => 'Ukuran gambar terlalu besar (max 2MB)'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $data = [
                'nama_produk' => $this->request->getPost('nama_produk'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'harga_produk' => $this->request->getPost('harga_produk'),
                'stok' => $this->request->getPost('stok'),
                'status' => 'pending'
            ];
    
            // Handle foto
            $foto = $this->request->getFile('foto_produk');
            if ($foto->isValid()) {
                $namaFoto = $foto->getRandomName();
                $foto->move('uploads/fotoProduk', $namaFoto);
                $data['foto_produk'] = $namaFoto;
    
                // Hapus foto lama
                $produk = $this->produkModel->find($id);
                if ($produk['foto_produk'] != 'default.jpg') {
                    unlink('uploads/fotoProduk/' . $produk['foto_produk']);
                }
            }
    
            $this->produkModel->update($id, $data);
    
            // Kirim notifikasi ke admin untuk verifikasi ulang
            $this->notificationController->sendNewProductNotification([
                'id' => $id,
                'nama_produk' => $data['nama_produk'],
                'type' => 'product_update'
            ]);
    
            return redirect()->to('/seller')->with('message', 'Produk berhasil diupdate dan menunggu verifikasi ulang');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate produk: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $produk = $this->produkModel->where([
                'produk_id' => $id,
                'user_id' => user()->id
            ])->first();
    
            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan');
            }
    
            // Hapus foto
            if ($produk['foto_produk'] != 'default.jpg') {
                $fotoPath = 'uploads/fotoProduk/' . $produk['foto_produk'];
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
            }
    
            $this->produkModel->delete($id);
    
            // Kirim notifikasi produk dihapus
            $this->notificationController->sendStatusChangeNotification(
                user()->id,
                'deleted',
                'product',
                [
                    'type' => 'product_deleted',
                    'product_name' => $produk['nama_produk']
                ]
            );
    
            return redirect()->to('/seller')->with('message', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
}
}