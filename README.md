**Kecik Cookie**
==========
Is libraries were created specifically for the Kecik Framework, this library This library is made to facilitate the use of cookies on the project we build. This library also supports data encryption so that we secure the cookie data.

**Installation**
-----------
Add the following line to the file composer.json located on the project we want to build.
```json
{
    "require": {
        "kecik/kecik": "1.0.*@dev",
        "kecik/cookie": "1.0.*@dev"
    }
}
```

Next, run the command
```shell
composer update
```

And wait until the update process is completed without error.
> **Note**: This library requires Kecik Framework, so we need to install Kecik Framework first, and then we can install this library.

## **How to use Cookie Library**

```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$cookie = new Kecik\Cookie($app);
```
Whereas if you want a cookie in an encrypted then we simply add the config encryption

```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();

//Config for encrypt cookie
$app->config->set('cookie.encrypt', TRUE);
$cookie = new Kecik\Cookie($app);
```

### **set()**
This Function/Method use for create/update a cookie.
```php
set(string $name, mixed $value)
```
**Example**:
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
This Function/Method use for get a value from a cookie.
```php
get(string $name)
```
**Example**:
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
This Function/Method use for delete a cookie.
```php
delete(string $name)
```
**Example**:
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
This Function/Method use for delete all cookie are exist.
**Example**:
```php
<?php
require "vendor/autoload.php";

$app = new Kecik\Kecik();
$cookie = new Kecik\Cookie($app);

$cookie->clear();
```
