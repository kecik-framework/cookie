**Kecik Cookie**
==========
Merupakan pustaka/library yang dibuat khusus Framework Kecik, pustaka/library ini dibuat untuk mempermudah dalam menggunakan cookie pada project yang kita bangun. Pustaka/Library ini juga mendukung enkripsi data sehingga data cookie kita aman.

**Installasi**
-----------
Tambahkan baris berikut ini pada file composer.json yang berlokasi pada project yang ingin kita bangun.
```json
{
    "require": {
        "kecik/kecik": "1.0.2-alpha",
        "kecik/cookie": "dev-master"
    }
}
```

Selanjutnya jalan kan perintah 
```shell
composer update
```

Dan tunggu sampai proses update selesai tanpa error.
> **Catatan**: Pustaka/Library ini membutuhkan Kecik Framework, jadi kita harus menginstall Kecik Framework terlebih dahulu, baru kita bisa menginstall Pustaka/Library ini.

## **Cara Pakai Pustaka/Library Cookie**

```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$cookie = new Kecik\Cookie($app);
```
Sedangkan jika inginkan cookie dalam keadaan terenkripsi maka kita cukup menambahkan config enkripsi

```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();

//Config untuk enkripsi cookie
$app->config->set('cookie.encrypt', TRUE);
$cookie = new Kecik\Cookie($app);
```

### **set()**
Fungsi /Method ini digunakan untuk membuat/mengupdate sebuah cookie.
```php
set(string $name, mixed $value)
```
**contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$cookie = new Kecik\Cookie($app);
$cookie->set('integer', 123);
$cookie->set('string', 'satu dua tiga');
$cookie->set('array', array('satu', 'dua', 'tiga'));
```

### **get()**
Fungsi/Method ini digunakan untuk mendapatkan nilai dari suatu cookie.
```php
get(string $name)
```
**Contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$cookie = new Kecik\Cookie($app);
$cookie->set('integer', 123);
$cookie->set('string', 'satu dua tiga');
$cookie->set('array', array('satu', 'dua', 'tiga'));

echo 'cookie Integer: '.$cookie->get('integer').'<br />';
echo 'cookie String: '.$cookie->get('string').'<br />';
echo 'cookie Array: ';
print_r($cookie->get('array'));
```

### **delete()**
Fungsi/Method ini digunakan untuk menghapus sebuah cookie.
```php
delete(string $name)
```
**Contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$cookie = new Kecik\Cookie($app);
$cookie->set('kecik_cookie', 'ini nilai cookie nya');

echo 'kecik_cookie: '.$cookie->get('kecik_cookie').'<br />';

$cookie->delete('kecik_cookie');
echo 'kecik_cookie: '.$cookie->get('kecik_cookie').'<br />';
```

### **clear()**
Fungsi/Method ini digunakan untuk menghapus semua cookie yang ada.
**Contoh**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$cookie = new Kecik\Cookie($app);

$cookie->clear();
```

