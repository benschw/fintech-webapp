<?php

class Fltk_CsvView implements Flfc_ResponseContent, Flfc_HasHeadersToSet, Flfc_Streamable {
	
	private $columns;
	private $rows;

	/**
	 * @param $fileName name of the file the user will be downloading
	 * @param array $columns all columns to display in table
	 * @param Iterable $rows iterable rows, each row should be an assoc array
	 *        where the keys are a subset of the columns 
	 */
	public function __construct($fileName, array $columns, Iterator $rows) {
		$this->fileName = $fileName;
		$this->columns  = $columns;
		$this->rows     = $rows;
	}
	
	public function getFileName() {
		return $this->fileName;
	}
	
	public function setHeadersOnResponse(Flfc_Response $response) {
		$response->addHeader(
			'Content-Type', 
			'application/unknown'
		);
		$response->addHeader(
			'Content-disposition', 
			sprintf('attachment; filename="%s"', basename($this->fileName))
		);
		$response->addHeader(
			'Cache-Control', 
			'must-revalidate, post-check=0, pre-check=0'
		);
		$response->addHeader(
			'Pragma', 
			'public'
		);
	}
	
	public function render() {}
	
	public function stream() {
		// CSV formatting is done in Util_Csv_StreamAdapter as each row is iterated over
		foreach ($this->rows as $row) {
			print $row;
		}
	}
	
	protected function formatRow($row) {
		$formattedFields = array();
		foreach ($row as $field) {
			$formattedFields[] = $this->formatField($field);
		}
		return implode(',', $row) . "\n";
	}
	
	protected function formatField($field) {
		$field = preg_replace('/\r\n/', ' ', $field);
		$field = preg_replace('/"/', '""', $field);
		if (is_int(strpos($field, ','))) {
			$field = '"' . $field . '"';
		}
		return $field;
	}
}

