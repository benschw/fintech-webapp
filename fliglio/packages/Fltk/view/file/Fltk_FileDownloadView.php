<?php

/**
 * File Download View
 *
 * @package Fltk
 */
class Fltk_FileDownloadView implements Flfc_ResponseContent, Flfc_HasHeadersToSet {

	const FILE_TYPE_AIR = 'air';
	const FILE_TYPE_TXT = 'txt';
	const FILE_TYPE_PDF = 'pdf';
	const FILE_TYPE_XML = 'xml';

	private static $contentType = array(
			self::FILE_TYPE_AIR => 'application/vnd.adobe.air-application-installer-package+zip .air',
			self::FILE_TYPE_TXT => 'text/plain',
			self::FILE_TYPE_PDF => 'application/pdf',
			self::FILE_TYPE_XML => 'text/xml'
		);

	protected $fileName;
	protected $fileType;
	protected $fileContents;

	/**
	 * @param string $fileName  e.g. "download.exe"
	 * @param string $fileType  e.g. Fltk_FileDownloadView::FILE_TYPE_AIR
	 * @param string $fileContents
	 */
	public function __construct($fileName, $fileType, $fileContents) {
		if (!isset(self::$contentType[$fileType])) {
			throw new Fltk_FileDownloadTypeNotSupported("$fileType not supported for download.");
		}

		$this->fileName     = $fileName;
		$this->fileType     = $fileType;
		$this->fileContents = $fileContents;
	}

	public function setHeadersOnResponse(Flfc_Response $response) {
		$response->addHeader('Expires', '0');
		$response->addHeader('Pragma', 'public');
		$response->addHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');

		$response->addHeader('Content-Type', 'application/force-download');
		$response->addHeader('Content-Type', 'application/octet-stream');
		$response->addHeader('Content-Type', 'application/download');

		$response->addHeader('Content-Type', self::$contentType[$this->fileType]);

		$response->addHeader('Content-Transfer-Encoding', 'binary');

		$response->addHeader('Content-disposition', sprintf('attachment; filename="%s"', $this->fileName));
	}

	public function render() {
		print($this->fileContents);
	}

}