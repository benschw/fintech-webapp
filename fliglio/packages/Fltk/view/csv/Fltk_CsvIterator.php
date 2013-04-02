<?php

class Fltk_CsvIterator implements Iterator {
	
	private $columns;
	private $rows;
	
	public function __construct(array $columns, Iterator $rows) {
		
		$this->columns = $columns;
		$this->rows = $rows;
	}

	public function rewind() {
		return $this->rows->rewind();
	}
	public function current() {
		$row = $this->rows->current();
		$arr = array();
		foreach ($this->columns as $column) {
			$arr[$column] = isset($row[$column]) ? $row[$column] : null;
		}
		return $arr;
	}
	public function key() {
		return $this->rows->key();
	}
	public function next() {
		$this->rows->next();
	}
	public function valid() {
		return $this->rows->valid();
	}
	public function count() {
		return $this->rows->count();
	}

	public function __destruct() {
		$this->rows->__destruct();
	}
}