<?php
/**
 * Encryption
 *
 * @package Util.Encryption
 */
class Util_Encryption_Encryption {
	
	const KEY = 'PR2tRus8eVucrAsaP5ZugEqEwr3PaC5A';
	
	public static function decrypt($encrypted_string) {
		$iv = substr($encrypted_string, 0, 16);
		$value = substr($encrypted_string, 16, strlen($encrypted_string));
		$value = base64_decode($value);
		
		$decrypted_string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, self::KEY, $value, MCRYPT_MODE_NOFB, $iv),"{");
		
		return $decrypted_string;
	}

	public static function encrypt($original_string) {
		$iv = self::randomize(16);
		$aes = new Util_Encryption_Aes(self::KEY, "OFB", $iv);
		$encrypted_string = $aes->encrypt($original_string);
		$encoded_string = base64_encode($encrypted_string);
		$encrypted_string = $iv . $encoded_string;
		return $encrypted_string;
	}
	
	public static function randomize($length) {
		$length = $length++;
		$string = "";
		for ($i=0; $i<$length; $i++) {
			$d = rand(1,30)%2;
			$string .= $d ? chr(rand(65,90)) : chr(rand(48,57));
		}
		return $string;
	}
}