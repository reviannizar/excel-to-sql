# excel-to-sql

Yii2 Tools for create sql from excel file

### Aplikasi tools membuat table dari excel

1. Membuat struktur tabel di excel (dengan format tertentu) kemudian di upload dan menjadi format sql

2. Membuat INSERT dan UPDATE dengan template dan data di excel 

3. upload dan menjadi format sql



### Latar belakang

1. Kebiasaan yang bisa dikatakan kurang baik, yaitu membuat aplikasi database dengan langsung mengetikkan query CREATE TABLE, INSERT dan UPDATE secara manual menggunakan text editor biasa.

2. Penulisan yang membosankan di text editor untuk merubah / menambah field, insert dan update data yang akan sangat mudah jika dilakukan di editor excel.



### Komponen yang digunakan

1. Button klik tampil open file dialog menggunakan class btn-file dari adminLTE

2. Upload file excel menggunakan jQuery File Upload Plugin http://blueimp.github.io/jQuery-File-Upload/

3. Ekstak file excel (.xls) menggunakan php-excel-reader http://code.google.com/p/php-excel-reader/wiki/Documentation


### Cara Instalasi

1. Aplikasi di jalankan menggunakan yii2

2. download dan ekstak ke folder vendor 

~~~
[@vendor/revian/jbiru/]
~~~

3. Tambah / edit bagian bawah file config/web.php 
  
~~~
return array_merge_recursive($config, require(dirname(__DIR__).'/vendor/revian/jbiru/config/web.php'));
~~~

4. Jalankan

~~~
xxx/web/index.php?r=admin/tools/excel-to-sql
~~~
atau
~~~
xxx/web/admin/excel-to-sql
~~~
