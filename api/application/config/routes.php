<?php

defined('BASEPATH') or exit('No direct script access allowed');



$route['default_controller'] = 'auth';
// $route['default_controller'] = 'auth';

$route['404_override'] = '';

$route['translate_uri_dashes'] = FALSE;



//gudang

//supplier

$route['gudang/dasbor'] = 'gudang/G_dasbor_c/index';

$route['gudang/supplier'] = 'gudang/Supplier_c/index';

$route['gudang/supplier_tambah'] = 'gudang/Supplier_c/tambah';

$route['gudang/supplier_ubah/(:any)'] = 'gudang/Supplier_c/ubah/$1';

$route['gudang/supplier_hapus/(:any)'] = 'gudang/Supplier_c/hapus/$1';



//barang

$route['gudang/barang'] = 'gudang/Barang_c/index';

$route['gudang/barang_tambah'] = 'gudang/Barang_c/tambah';

$route['gudang/barang_ubah/(:any)'] = 'gudang/Barang_c/ubah/$1';

$route['gudang/barang_hapus/(:any)'] = 'gudang/Barang_c/hapus/$1';

$route['gudang/barang_detail/(:any)'] = 'gudang/Barang_c/index/$1';

//satuan

$route['gudang/satuan'] = 'gudang/Satuan_c/index';

$route['gudang/satuan_tambah'] = 'gudang/Satuan_c/tambah';

$route['gudang/satuan_hapus/(:any)'] = 'gudang/Satuan_c/hapus/$1';



//sales

//pelanggan

$route['sales/dasbor'] = 'sales/S_dasbor_c/index';

$route['sales/pelanggan'] = 'sales/Pelanggan_c/index';

$route['sales/pelanggan_tambah'] = 'sales/Pelanggan_c/tambah';

$route['sales/pelanggan_ubah/(:any)'] = 'sales/Pelanggan_c/ubah/$1';

$route['sales/pelanggan_hapus/(:any)'] = 'sales/Pelanggan_c/hapus/$1';



$route['sales/surat_jalan'] = 'sales/Surat_jalan_c/index';

$route['sales/surat_jalan_tambah'] = 'sales/Surat_jalan_c/tambah';

$route['sales/surat_jalan_ubah/(:any)'] = 'sales/Surat_jalan_c/ubah/$1';

$route['sales/surat_jalan_hapus/(:any)'] = 'sales/Surat_jalan_c/hapus/$1';

$route['sales/surat_jalan_detail/(:any)'] = 'sales/Surat_jalan_c/index/$1';

$route['sales/surat_jalan_cetak/(:any)'] = 'sales/Surat_jalan_c/cetak/$1';

$route['sales/penjualan/(:any)'] = 'sales/Penjualan_c/index/$1';

$route['sales/penjualan_add/(:any)'] = 'sales/Penjualan_c/add/$1';

$route['sales/penjualan_tambah'] = 'sales/Penjualan_c/tambah';

$route['sales/penjualan_cetak/(:any)'] = 'sales/Penjualan_c/cetak/$1';

$route['sales/pengembalian_add/(:any)'] = 'sales/Pengembalian_c/add/$1';

$route['sales/pengembalian_tambah'] = 'sales/Pengembalian_c/tambah';

$route['sales/pengembalian/(:any)'] = 'sales/Pengembalian_c/index/$1';

$route['sales/pengembalian_cetak/(:any)'] = 'sales/Pengembalian_c/cetak/$1';

$route['sales/pesan_ulang'] = 'sales/Pesan_ulang_c/index/';

$route['sales/pesan_ulang/(:any)'] = 'sales/Pesan_ulang_c/index/$1';

$route['sales/pesan_ulang_detail/(:any)'] = 'sales/Pesan_ulang_c/index/$1';

$route['sales/pesan_ulang_tambah'] = 'sales/Pesan_ulang_c/tambah';

$route['sales/pesan_ulang_cetak/(:any)'] = 'sales/Pesan_ulang_c/cetak/$1';

$route['sales/pesan_ulang_cetak_andro?(:any)'] = 'rest/sales/Pesan_ulang/cetak?$1';



//supervisor

$route['supervisor/dasbor'] = 'supervisor/SP_dasbor_c/index';

$route['supervisor/verif_surat_jalan'] = 'supervisor/Verif_surat_jalan_c/index';

$route['supervisor/surat_jalan_detail/(:any)'] = 'supervisor/Verif_surat_jalan_c/index/$1';

$route['supervisor/verifikasi_surat_jalan/(:any)'] = 'supervisor/Verif_surat_jalan_c/verifikasi_surat_jalan/$1';

$route['supervisor/tolak_surat_jalan/(:any)'] = 'supervisor/Verif_surat_jalan_c/tolak_surat_jalan/$1';



$route['supervisor/verif_pesan_ulang'] = 'supervisor/Verif_pesan_ulang_c/index';

$route['supervisor/getgps'] = 'supervisor/Getgps/index';

$route['supervisor/datagps/getmap/(:any)'] = 'supervisor/Datagps/index/$1';

$route['supervisor/datagps/getmap2'] = 'supervisor/Datagps/getmap2/';

$route['supervisor/pesan_ulang_detail/(:any)'] = 'supervisor/Verif_pesan_ulang_c/index/$1';

$route['supervisor/verifikasi_pesan_ulang/(:any)'] = 'supervisor/Verif_pesan_ulang_c/verifikasi_pesan_ulang/$1';

$route['supervisor/tolak_pesan_ulang/(:any)'] = 'supervisor/Verif_pesan_ulang_c/tolak_pesan_ulang/$1';


//kunjungan

$route['supervisor/kunjungan'] = 'supervisor/Kunjungan_c/index';

$route['supervisor/kunjungan_tambah'] = 'supervisor/Kunjungan_c/tambah';

$route['supervisor/kunjungan_ubah/(:any)'] = 'supervisor/Kunjungan_c/ubah/$1';

$route['supervisor/kunjungan_hapus/(:any)'] = 'supervisor/Kunjungan_c/hapus/$1';

$route['supervisor/kunjungan_detail/(:any)'] = 'supervisor/Kunjungan_c/index/$1';


//laporan

$route['laporan/penjualan'] = 'laporan/L_penjualan_c/index';

$route['laporan/penjualan_andro/(:any)'] = 'rest/laporan/Laporan_penjualan/cetak/$1';

$route['laporan/penjualan2'] = 'laporan/L_penjualan_c2/cetak';

$route['laporan/penjualan_view'] = 'laporan/L_penjualan_c/view';

$route['laporan/penjualan_cetak'] = 'laporan/L_penjualan_c/cetak';

$route['laporan/penjualan_viewg'] = 'laporan/L_penjualan_c/viewg';

$route['laporan/penjualan_cetakg'] = 'laporan/L_penjualan_c/cetakg';



$route['laporan/pengembalian'] = 'laporan/L_pengembalian_c/index';

$route['laporan/pengembalian_view'] = 'laporan/L_pengembalian_c/view';

$route['laporan/pengembalian_cetak'] = 'laporan/L_pengembalian_c/cetak';

$route['laporan/pengembalian_andro/(:any)'] = 'rest/laporan/Laporan_pengembalian/cetak/$1';



$route['laporan/pesanulang'] = 'laporan/L_pesanulang_c/index';

$route['laporan/pesanulang_view'] = 'laporan/L_pesanulang_c/view';

$route['laporan/pesanulang_cetak'] = 'laporan/L_pesanulang_c/cetak';

$route['laporan/pesanulang_andro/(:any)'] = 'rest/laporan/Laporan_pesan_ulang/cetak/$1';

$route['laporan/sales_cetak'] = 'laporan/L_sales_c/cetak';


$route['laporan/linimasa'] = 'laporan/L_linimasa_c/index';

$route['laporan/linimasa_andro/(:any)'] = 'rest/laporan/Laporan_linimasa/cetak/$1';

$route['laporan/linimasa2'] = 'laporan/L_linimasa_c2/cetak';

$route['laporan/linimasa_view'] = 'laporan/L_linimasa_c/view';

$route['laporan/linimasa_cetak'] = 'laporan/L_linimasa_c/cetak';

$route['laporan/linimasa_map/(:any)'] = 'laporan/L_linimasa_c/map/$1';

$route['laporan/linimasa_viewg'] = 'laporan/L_linimasa_c/viewg';

$route['laporan/linimasa_cetakg'] = 'laporan/L_linimasa_c/cetakg';

$route['supervisor/sales'] = 'supervisor/Sales_c/index';

