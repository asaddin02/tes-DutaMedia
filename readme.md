# Panduan Penggunaan Nama Proyek Anda

Pembuatan ini belum sampai tahap API namun beberapa fungsi sudah sesuai dan kode ini menggunakan psr-4.

## Cara Menggunakan

1. Taruh folder ini di dalam htdocs jika menggunakan XAMPP atau www jika Laragon.(sesuaikan)
2. Didalam file index.php terdapat $obj yang digunakan sebagai pemanggil kelas Controller.
3. Panggil Fungsi yang sesuai untuk melihat hasilnya secara langsung.
4. Gunakan String untuk parameter tiap fungsi.

## Format Fungsi

- function simpan dan ubah product

1. $obj->store("P012", "Chocolate", "2023-08-01", "20000");
2. $obj->edit("2","P012", "Chocolate", "2023-08-01", "20000");

- function cari berdasarkan code

1. $obj->search("P012"); 

- function tampil list product dengan halaman

1. $obj->productWithPaging("5","1"); 

- function hapus dan restore product

1. $obj->deleteProduct("5"); 
1. $obj->restoreProduct("5"); 