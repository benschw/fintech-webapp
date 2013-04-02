<?php

/**
 * Physical file or directory wrapper
 *
 * @package Util.Io
 */
class Util_Io_File {

	const DEFAULT_MODE = 0775;

	private $path;

	public function __construct($path) {
		$this->setPath($path);
	}
	
	/**
	 * Singleton getter
	 *
	 * @param string $path 
	 * @return Util_Io_File
	 */
	public static function get($path) {
		return new self($path);
	}
	
	public function setPath($path) {
		$this->path = rtrim($path, '/');
	}

	public function setContents($content) {
		if ($this->isDirectory()) {
			throw new Util_Io_Exception(sprintf("Cannot set content to directory '%s'", $this->path));
		}

		file_put_contents($this->path, (string)$content);
	}
	
	public function appendContents($content) {
		if ($this->isDirectory()) {
			throw new Util_Io_Exception(sprintf("Cannot set content to directory '%s'", $this->path));
		}

		file_put_contents($this->path, (string)$content, FILE_APPEND);
	}
	
	public function getParent() {
		return dirname($this->path);
	}

	public function getPath() {
		return $this->path;
	}

	/**
	 * Get File contents
	 *
	 * @return void
	 */
	public function getContents() {
		if ($this->isDirectory()) {
			throw new Util_Io_Exception(sprintf("Cannot get contents of directory '%s'", $this->path));
		}

		return file_get_contents($this->path);
	}

	public function getRelative(Util_Io_File $root) {
		if (strpos((string) $this, (string) $root) === 0) {
			$path = substr((string) $this, strlen((string) $root));
			return new Util_Io_File(ltrim($path, "/"));
		}
		
		throw new Util_Io_Exception(sprintf("'%s' is not a valid root", (string) $root));
	}

	public function getCreatedTime() {
		return filemtime($this->path);
	}

	public function isAbsolute() {
		return substr($this->path, 0, 1) == '/';
	}

	public function isDirectory() {
		return is_dir($this->path);
	}

	public function isFile() {
		return is_file($this->path);
	}

	public function exists() {
		return $this->isFile() || $this->isDirectory();
	}

	/**
	 * Join with another path
	 *
	 * @param Util_Io_File $child 
	 * @return Util_Io_File
	 */
	public function join(Util_Io_File $child) {
		if ($this->isFile()) {
			throw new Util_Io_Exception(sprintf("Base Path '%s' cannot be a file", $this->getPath()));
		}
		
		if ($child->isAbsolute()) {
			throw new Util_Io_Exception(sprintf("Child Path '%s' cannot be absolute", $child->getPath()));
		}
		
		return new self((string) $this . '/' . (string) $child);
	}
	
	/**
	 * Makes directory named by this object's path, 
	 * or makes $child inside this object's path
	 *
	 * @param string $mode (optional)       mode to create folder(s) as
	 * @param boolean $recursive (optional) create all folders in path if they 
	 *                                      don't exist
	 * @return void
	 */
	public function mkdir($mode = self::DEFAULT_MODE, $recursive = false) {
		if (!$this->isAbsolute()) {
			throw new Util_Io_Exception(sprintf("File Path '%s' must be absolute: Cannot Create", $this->getPath()));
		}
		
		if ($this->exists()) {
			throw new Util_Io_Exception(sprintf("File Path '%s' already exists: Cannot Create", $this->getPath()));
		}
		
		try {
			if (!mkdir($this->getPath(), $mode, $recursive)) {
				throw new Util_Io_Exception(sprintf("Directory '%s' could not be created: 'mkdir()' Failed", $this->getPath()));
			}
			chmod($this->getPath(), $mode);
		} catch (Exception $e) {
			throw new Util_Io_Exception($e->getMessage());
		}
		return $this;
	}
	
	public function touch() {
		if (!$this->isAbsolute()) {
			throw new Util_Io_Exception(sprintf("File Path '%s' must be absolute: Cannot Create", $this->getPath()));
		}
		try {
			if (!touch($this->getPath())) {
				throw new Util_Io_Exception(sprintf("Directory '%s' could not be created: 'mkdir()' Failed", $this->getPath()));
			}
		} catch (Exception $e) {
			throw new Util_Io_Exception($e->getMessage());
		}
		return $this;
	}
	
	public function unlink() {
		if (!$this->isAbsolute()) {
			throw new Util_Io_Exception(sprintf("File Path '%s' must be absolute: Cannot Create", $this->getPath()));
		}
		if (!$this->exists()) {
			throw new Util_Io_Exception(sprintf("File Path '%s' Doesn't exist: Cannot Unlink", $this->getPath()));
		}
		try {
			if (!unlink($this->getPath())) {
				throw new Util_Io_Exception(sprintf("Directory '%s' could not be created: 'mkdir()' Failed", $this->getPath()));
			}
		} catch (Exception $e) {
			throw new Util_Io_Exception($e->getMessage());
		}
		return $this;
	}
	
	/**
	 * Checks mimeType and extension of file
	 *
	 * @param object $file UplaodedFile object derived from $_FILES[]
	 * @param string $extension Required extension: e.g. 'ico', 'image', 'air'.
	 * @return boolean
	 */
	public static function verifyFileType(Util_Io_UploadedFile $file, $extension) {
		$extensionVerified = false;
		$mimeVerified = false;
		$extensions = array();
		$mimeTypes = array();
		
		switch ($extension) {
			case 'ico': 
				$mimeTypes = array('image/x-ico');
				$extensions = array('ico');
				break;
			case 'xml':
				$mimeTypes = array('text/xml', 'text/plain');
				$extensions = array('xml');
				break;
			case 'air':
				$mimeTypes = array('application/zip', 'application/octet-stream');
				$extensions = array('air');
				break;
			case 'image':
				$mimeTypes = array('image/png', 'image/gif', 'image/jpg', 'image/jpeg');
				$extensions = array('png', 'gif', 'jpg', 'jpeg');
				break;
			case 'pdf':
			// Sample of individual image type, expand as needed.
				$mimeTypes = array('application/pdf');
				$extensions = array('pdf');
				break;
			case 'png':
			// Sample of individual image type, expand as needed.
				$mimeTypes = array('image/png');
				$extensions = array('png');
				break;
			default:
				break;
		}
		
		foreach ($extensions as $extension) {
			if (substr(strrchr($file->getFileName(), '.'), 1) == $extension) {
				$extensionVerified = true;
				break;
			}
		}
		foreach ($mimeTypes as $mimeType) {
			if (mime_content_type($file->getFilePath()) == $mimeType) {
				$mimeVerified = true;
				break;
			}
		}
		
		return $mimeVerified && $extensionVerified;
	}
	
	public function __toString() {
		return $this->path;
	}
}