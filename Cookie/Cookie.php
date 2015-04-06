<?php
/**
 * Cookie - Library untuk framework kecik, library ini khusus untuk membantu masalah Cookie 
 *
 * @author 		Dony Wahyu Isp
 * @copyright 	2015 Dony Wahyu Isp
 * @link 		http://github.io/kecik_cookie
 * @license		MIT
 * @version 	1.0.1-alpha
 * @package		Kecik\Cookie
 **/
namespace Kecik;

/**
 * Cookie
 * @package 	Kecik\Cokie
 * @author 		Dony Wahyu Isp
 * @since 		1.0.1-alpha
 **/
class Cookie {
	/**
	 * @var bool $status
	 **/
	private $status=FALSE;

	private $key;
	private $iv;


	/**
 	 * __construct
 	 * @param Kecik $app
 	 **/
	public function __construct(Kecik $app) {
		$config = $app->config;
		if ( empty( $this->status = $config->get('cookie.encrypt') ) )
			$this->status = FALSE;
		else { 
			if ( empty( $key = $config->get('cookie.encrypt.key') ) )
				$this->key = pack('H*', $key);
			else
				$this->key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

			if (empty($_COOKIE['eivk'.md5($app->url->baseUrl())]) || !ctype_print($_COOKIE['eivk'.md5($app->url->baseUrl())]))
				unset($_SESSION['eivk'.md5($app->url->baseUrl())]);

			if (empty($_COOKIE['eivk'.md5($app->url->baseUrl())]) && empty($_SESSION['eivk'.md5($app->url->baseUrl())])) {
				$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	            $this->iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	            $this->iv = base64_encode($this->iv);
	            setcookie('eivk'.md5($app->url->baseUrl()), $this->iv, 0, '/');
	            $_SESSION['eivk'.md5($app->url->baseUrl())] = $this->iv;
        	} else {
            	if (!empty($_SESSION['eivk'.md5($app->url->baseUrl())])) {
            		$this->iv = $_SESSION['eivk'.md5($app->url->baseUrl())];
            		setcookie('eivk'.md5($app->url->baseUrl()), $this->iv, 0, '/');
        		} elseif (!empty($_COOKIE['eivk'.md5($app->url->baseUrl())])) {
        			$this->iv = $_COOKIE['eivk'.md5($app->url->baseUrl())];
            		$_SESSION['eivk'.md5($app->url->baseUrl())] = $this->iv;
        		}
        	}
		}

	}

	/**
	 * set
	 * @param string $name
	 * @param mixed $value
	 **/
	public function set($name, $value, $expire=0, $path='', $domain='', $secure=FALSE, $httponly=FALSE) {
		$_COOKIE[$name] = $this->encrypt( $value );
		return setcookie($name, $_COOKIE[$name], $expire, $path, $domain, $secure, $httponly);
	}

	/**
	 * get
	 * @param string $name
	 * @return mixed
	 **/
	public function get($name) {
		if (isset($_COOKIE[$name]))
			return $this->decrypt( $_COOKIE[$name] );
		else
			return NULL;
	}

	/**
	 * delete
	 * @param string $name
	 **/
	public function delete($name) {
		if (isset($_COOKIE[$name]))
			unset($_COOKIE[$name]);
	}

	/**
	 * clear
	 * Hapus semua session
	 **/
	public function clear() {
		while (list($name, $value) = each($_COOKIE)) {
			$this->delete($name);
		}
	}

	/**
	 * encrypt
	 * enkripsi cookie
	 * @param string $plaintext
	 * @return string
	 **/
	private function encrypt($plaintext) {
		if (is_array($plaintext))
			$ciphertext = json_encode($plaintext);
		else
			$ciphertext = $plaintext;

		if ($this->status) {
			$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $ciphertext, MCRYPT_MODE_CBC, base64_decode($this->iv));
		}

		return $ciphertext;
	}

	/**
	 * decrypt
	 * dekripsi cookie
	 * @param string $ciphertext
	 * @return mixed
	 **/
	private function decrypt($ciphertext) {
		$plaintext = $ciphertext;

		if ($this->status) {
			$plaintext = trim( mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, base64_decode($ciphertext), MCRYPT_MODE_CBC, base64_decode($this->iv)) );
			$plaintext_array = json_decode($plaintext, TRUE);
			if ($plaintext_array)
				$plaintext = $plaintext_array;
		}

		return $plaintext;
	}
}