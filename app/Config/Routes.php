<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Authentication Route
$routes->get('auth/redirect', 'Auth::redirect');
$routes->get('/', 'Auth::redirect');
$routes->get('/offline.html', 'Home::offline');
$routes->add('/ping', 'Auth::ping');//cek jaringan

// Forgot Password Route
$routes->get('forgot', 'ForgotPasswordController::index');
$routes->post('forgot', 'ForgotPasswordController::sendResetLink');

// Reset Password Route (Protected)
$routes->group('', ['filter' => 'login'], function($routes) {
    $routes->get('reset-password', 'ResetPasswordController::index');
    $routes->post('reset-password/update', 'ResetPasswordController::update');
    $routes->post('reset-password/reset', 'ResetPasswordController::reset');
});

// Routes (Protected)
$routes->group('', ['filter' => 'login'], function($routes) {
    $routes->get('/profile', 'Home::myProfile');
    $routes->get('/contact', 'Home::contact');
    $routes->post('/contact/save', 'Contact::saveMessage');
    $routes->get('/help', 'Home::help');
    $routes->get('/about', 'Home::about');
    
    // Notifikasi Route
    $routes->group('notifikasi', function($routes) {
        $routes->get('/', 'NotifikasiController::index');
        $routes->get('markAsRead/(:num)', 'NotifikasiController::markAsRead/$1');
        $routes->get('getUnreadCount', 'NotifikasiController::getUnreadCount');
    });
    $routes->post('notification/save-token', 'NotificationController::saveToken');
    
    // Riwayat Route
    $routes->group('riwayat', function($routes) {
        $routes->get('point', 'RiwayatController::riwayatPoint');
        $routes->get('saldo', 'RiwayatController::riwayatSaldo', ['filter' => 'role:seller']);
    });
});

// Admin Route
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('index', 'Admin::index');
    $routes->get('user-management', 'UserManagementController::index');
    $routes->post('user/activation', 'UserManagementController::updateActivation');
    $routes->get('user/(:num)', 'UserManagementController::detail/$1');
    
    // Transaksi Management
    $routes->get('transaksi_sampah', 'Admin::transaksi');
    $routes->post('transaksi_sampah/verifikasi/(:num)', 'Admin::verifikasiTransaksi/$1');
    $routes->get('transaksi_produk', 'Admin::produk');
    $routes->post('transaksi_produk/verifikasi/(:num)', 'Admin::verifikasiProduk/$1');
    $routes->get('sampah', 'Admin::totalSampah');
    $routes->post('verifikasi-penarikan/(:num)', 'Admin::prosesVerifikasiPenarikan/$1');
    $routes->post('verifikasi-penukaran/(:num)', 'Admin::verifikasiPenukaran/$1');
    $routes->get('transaksi_penarikan', 'Admin::verifikasiPenarikan');
    
    // Laporan
    $routes->get('laporan', 'LaporanController::index');
    $routes->get('laporan/excel', 'LaporanController::exportExcel');
    $routes->get('laporan/pdf', 'LaporanController::exportPDF');
});

// Nasabah Route
$routes->group('user', ['filter' => 'role:nasabah'], function($routes) {
    $routes->get('/', 'User::index');
    $routes->get('riwayatPenarikan', 'RiwayatController::RiwayatPenarikan');
    $routes->get('riwayat_point', 'RiwayatController::riwayatPoint');
    $routes->post('ewallet/store', 'EwalletController::storeNasabah');
});
    $routes->get('jualSampah', 'TransaksiController::create', ['filter' => 'role:nasabah']);
    $routes->get('tukarProduk', 'User::tukarProduk', ['filter' => 'role:nasabah']);
    $routes->get('tentangKita', 'User::tentangKita', ['filter' => 'role:nasabah']);
    // Transaksi Routes
    $routes->get('transaksi/create', 'TransaksiController::create', ['filter' => 'role:nasabah']);
    $routes->get('transaksi/getHarga/(:num)', 'TransaksiController::getHarga/$1', ['filter' => 'role:nasabah']);
    $routes->post('transaksi/store', 'TransaksiController::store', ['filter' => 'role:nasabah']);
    // Produk Routes
    $routes->get('tukar-produk/(:num)', 'PenukaranController::tukarProduk/$1', ['filter' => 'role:nasabah']);
    $routes->get('detail-penukaran/(:num)', 'PenukaranController::detailPenukaran/$1', ['filter' => 'role:nasabah']);



// Seller
$routes->group('seller', ['filter' => 'role:seller'], function($routes) {
    $routes->get('/', 'Seller::index');
    $routes->get('riwayatPenarikan', 'RiwayatController::RiwayatPenarikan');
    $routes->get('riwayat_saldo', 'RiwayatController::riwayatSaldo');
    // Produk Management
    $routes->get('produk/create', 'ProdukController::create');
    $routes->post('produk/store', 'ProdukController::store');
    $routes->get('produk/edit/(:num)', 'ProdukController::edit/$1');
    $routes->put('produk/update/(:num)', 'ProdukController::update/$1');
    $routes->delete('produk/delete/(:num)', 'ProdukController::delete/$1');
    
    // E-wallet
    $routes->post('ewallet/store', 'EwalletController::storeSeller');
});