<?php
/**
 * 
 * @package Web
 */
class Web_FtpFile extends Web_FtpItem {

	private $remoteFileName;
	private $localFilePath;


	public function __construct($remoteFileName, $localFilePath) {
		$this->remoteFileName = $remoteFileName;
		$this->localFilePath  = $localFilePath;
	}

 	public function getRemoteFileName() {
		return $this->remoteFileName;
	}
	
 	public function getLocalFilePath() {
		return $this->localFilePath;
	}

	public function setLocalFilePath($val) {
		$this->localFilePath = $val;
	}
		
	public function setRemoteFileName($val) {
		$this->remoteFileName = $val;
	}
}