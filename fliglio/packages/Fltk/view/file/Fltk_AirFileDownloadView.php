<?php

/**
 * Text File Download View
 *
 * @package Fltk
 */
class Fltk_AirFileDownloadView extends Fltk_FileDownloadView {

	public function __construct($fileName, $fileContents) {
		parent::__construct($fileName, parent::FILE_TYPE_AIR, $fileContents);
	}

}