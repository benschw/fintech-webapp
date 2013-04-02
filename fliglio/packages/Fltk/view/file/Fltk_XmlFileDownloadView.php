<?php

/**
 * Xml File Download View
 *
 * @package Fltk
 */
class Fltk_XmlFileDownloadView extends Fltk_FileDownloadView {

	public function __construct($fileName, $fileContents) {
		parent::__construct($fileName, parent::FILE_TYPE_XML, $fileContents);
	}

}