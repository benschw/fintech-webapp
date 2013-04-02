<?php

/**
 * Object containing the properties of an uploaded file
 * 
 * @package Util
 */
class Util_Io_UploadedFile {
	
	private $fileName;
	private $filePath;
	private $error;
	private $fileSize;
	
	public function __construct($file) {
		$this->setFileName($file['name']);
		$this->setFilePath($file['tmp_name']);
		$this->setError($file['error']);
		$this->setFileSize($file['size']);
	}
	
	public function setFileName($val) {
		$this->fileName = $val;
	}	
	public function setFilePath($val) {
		$this->filePath = $val;
	}
	public function setError($val) {
		$this->error = $val;
	}
	public function setFileSize($val) {
		$this->fileSize = $val;
	}
	public function getFileName() {
		return $this->fileName ;
	}
	public function getFilePath() {
		return $this->filePath;
	}
	public function getError() {
		return $this->error;
	}
	public function getFileSize() {
		return $this->fileSize;
	}
}