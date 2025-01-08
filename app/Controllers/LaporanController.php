<?php

namespace App\Controllers;

use App\Models\PenarikanEwalletModel;
use App\Models\PenukaranProdukModel;
use App\Models\ProdukModel;
use App\Models\TransaksiSampahModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends BaseController
{
    protected $transaksiModel;
    protected $penukaranModel;
    protected $produkModel;
    protected $ewalletModel;
    protected $helpers = ['text'];

    public function __construct()
    {
        $this->transaksiModel = new TransaksiSampahModel();
        $this->penukaranModel = new PenukaranProdukModel();
        $this->produkModel = new ProdukModel();
        $this->ewalletModel = new PenarikanEwalletModel();
    }

    public function index()
    {
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-1 month'));
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-d');

        $transactions = $this->getAllTransactions($start_date, $end_date);

        $data = [
            'title' => 'Laporan Transaksi',
            'transactions' => $transactions,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        return view('admin/laporan', $data);
    }

    private function getAllTransactions($start_date, $end_date)
    {
        $sampah = $this->transaksiModel->select('
                transaksi_sampah.*, 
                users.username,
                "transaksi_sampah" as tipe_transaksi,
                kategori_sampah.nama_kategori
            ')
            ->join('users', 'users.username = transaksi_sampah.username')
            ->join('kategori_sampah', 'kategori_sampah.kategori_id = transaksi_sampah.kategori')
            ->where('DATE(transaksi_sampah.created_at) >=', $start_date)
            ->where('DATE(transaksi_sampah.created_at) <=', $end_date)
            ->findAll();

        $penukaran = $this->penukaranModel->select('
                penukaran_produk.*, 
                users.username,
                "penukaran_produk" as tipe_transaksi,
                produk.nama_produk
            ')
            ->join('users', 'users.id = penukaran_produk.user_id')
            ->join('produk', 'produk.produk_id = penukaran_produk.produk_id')
            ->where('DATE(penukaran_produk.created_at) >=', $start_date)
            ->where('DATE(penukaran_produk.created_at) <=', $end_date)
            ->findAll();

        $ewallet = $this->ewalletModel->select('
                penarikan_ewallet.*, 
                users.username,
                "penarikan_ewallet" as tipe_transaksi
            ')
            ->join('users', 'users.id = penarikan_ewallet.user_id')
            ->where('DATE(penarikan_ewallet.created_at) >=', $start_date)
            ->where('DATE(penarikan_ewallet.created_at) <=', $end_date)
            ->findAll();

        $all_transactions = array_merge($sampah, $penukaran, $ewallet);
        usort($all_transactions, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $all_transactions;
    }

    public function exportExcel()
    {
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $transactions = $this->getAllTransactions($start_date, $end_date);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Tipe Transaksi');
        $sheet->setCellValue('D1', 'Detail');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Point/Nominal');

        $row = 2;
        foreach ($transactions as $t) {
            $sheet->setCellValue('A' . $row, date('d/m/Y H:i', strtotime($t['created_at'])));
            $sheet->setCellValue('B' . $row, $t['username']);
            $sheet->setCellValue('C' . $row, ucwords(str_replace('_', ' ', $t['tipe_transaksi'])));

            switch ($t['tipe_transaksi']) {
                case 'transaksi_sampah':
                    $detail = "{$t['nama_kategori']} - {$t['berat_sampah']} kg";
                    break;
                case 'penukaran_produk':
                    $detail = $t['nama_produk'];
                    break;
                case 'penarikan_ewallet':
                    $detail = "Penarikan ke {$t['no_ewallet']}";
                    break;
            }
            
            $sheet->setCellValue('D' . $row, $detail);
            $sheet->setCellValue('E' . $row, ucfirst($t['status']));
            $sheet->setCellValue('F' . $row, isset($t['point_sampah_dijual']) ? $t['point_sampah_dijual'] : 
                                            (isset($t['point_tukar']) ? $t['point_tukar'] : 
                                            $t['jumlah_point']));
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Transaksi.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    public function exportPDF()
    {
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $transactions = $this->getAllTransactions($start_date, $end_date);

        $dompdf = new Dompdf();

        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                h2 { text-align: center; margin-bottom: 5px; }
                .periode { text-align: center; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #000; padding: 5px; font-size: 12px; }
                th { background-color: #f4f4f4; }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
                .badge {
                    padding: 3px 8px;
                    border-radius: 3px;
                    font-size: 11px;
                    color: white;
                }
                .badge-success { background-color: #28a745; }
                .badge-warning { background-color: #ffc107; color: black; }
                .badge-danger { background-color: #dc3545; }
            </style>
        </head>
        <body>
            <h2>LAPORAN TRANSAKSI</h2>
            <div class="periode">
                Periode: ' . date('d/m/Y', strtotime($start_date)) . ' - ' . date('d/m/Y', strtotime($end_date)) . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Username</th>
                        <th>Tipe Transaksi</th>
                        <th>Detail</th>
                        <th>Status</th>
                        <th>Point/Nominal</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($transactions as $t) {
            switch ($t['tipe_transaksi']) {
                case 'transaksi_sampah':
                    $detail = "{$t['nama_kategori']} - {$t['berat_sampah']} kg";
                    break;
                case 'penukaran_produk':
                    $detail = $t['nama_produk'];
                    break;
                case 'penarikan_ewallet':
                    $detail = "Penarikan ke {$t['no_ewallet']}";
                    break;
            }

            $badgeClass = '';
            switch ($t['status']) {
                case 'pending':
                    $badgeClass = 'badge-warning';
                    break;
                case 'approved':
                    $badgeClass = 'badge-success';
                    break;
                case 'rejected':
                    $badgeClass = 'badge-danger';
                    break;
            }

            $html .= '
            <tr>
                <td>' . date('d/m/Y H:i', strtotime($t['created_at'])) . '</td>
                <td>' . $t['username'] . '</td>
                <td>' . ucwords(str_replace('_', ' ', $t['tipe_transaksi'])) . '</td>
                <td>' . $detail . '</td>
                <td class="text-center">
                    <span class="badge ' . $badgeClass . '">' . ucfirst($t['status']) . '</span>
                </td>
                <td class="text-right">' . number_format(
                    isset($t['point_sampah_dijual']) ? $t['point_sampah_dijual'] : 
                    (isset($t['point_tukar']) ? $t['point_tukar'] : $t['jumlah_point'])
                ) . '</td>
            </tr>';
        }

        $html .= '
                </tbody>
            </table>
            <div style="margin-top: 20px; text-align: right;">
                <p>Total Transaksi: ' . count($transactions) . '</p>
            </div>
        </body>
        </html>';

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream('Laporan_Transaksi.pdf', ['Attachment' => true]);
    }
}