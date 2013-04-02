<?php

/**
 * 
 * @package Web
 */
class Web_CurlFtp {
	
	private $ftpServer;
	private $ftpUser;
	private $ftpPass;
	private $isSecure = false;
	const FTP_PROTOCOL  = 'ftp';
	const SFTP_PROTOCOL = 'sftp';
	const FTP_URL       = "%s://%s%s@%s/%s";
	
	public function __construct($ftpServer, $ftpUser, $ftpPass = '') {
		$this->ftpServer = $ftpServer;
		$this->ftpUser   = $ftpUser;
		$this->ftpPass   = $ftpPass;
	}
	
	public function put(Web_FtpItem $item) {
		if ($item instanceof Web_FtpFile) {
			return $this->putFile($item);
		}
	}
	
	public function setSecure($val) {
		$this->isSecure = $val;
	}
	
	private function putFile(Web_FtpFile $file) {
		$fp = fopen($file->getLocalFilePath(), 'r');
		
		if ($this->isSecure) {
			$ftp      = self::SFTP_PROTOCOL;
		} else {
			throw new Exception("Only SFTP is tested. FTP protocol might not work.");
			$ftp      = self::FTP_PROTOCOL;
		}
		
		$ch = curl_init();
		$ftpPath = sprintf(self::FTP_URL, $ftp, $this->ftpUser, $this->ftpPass, $this->ftpServer, $file->getRemoteFileName());
		curl_setopt($ch, CURLOPT_URL, $ftpPath);
		curl_setopt($ch, CURLOPT_FTP_CREATE_MISSING_DIRS, 1);
		curl_setopt($ch, CURLOPT_UPLOAD, 1);
		curl_setopt($ch, CURLOPT_INFILE, $fp);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file->getLocalFilePath()));
		curl_exec ($ch);

		if (curl_errno($ch) != 0) {
			throw new Web_CurlFtpFailureException("FTP error: " . curl_errno($ch) . " message: " . curl_error($ch));
		}
		curl_close ($ch);
		return true;
	}
}