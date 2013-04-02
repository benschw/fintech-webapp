<?php

/**
 * Text PDF File Download View
 *
 * @package Fltk
 */
class Fltk_PdfFileDownloadView extends Fltk_FileDownloadView {

	public function __construct($fileName, $fileContents) {
		parent::__construct($fileName, parent::FILE_TYPE_PDF, $fileContents);
	}

}