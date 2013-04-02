<?php
/**
 * Csb Stream Adapter
 *
 * @package Util.Csv
 */
class Util_Csv_StreamAdapter implements Iterator {
	protected $iterator;
	
	public function __construct($itor) {
		if ($itor instanceof IteratorAggregate) {
			$itor = $itor->getIterator();
		}
		
		$this->iterator = $itor;
	}
	
	public function current() {
		$item = $this->iterator->current();
		
		if (!is_array($item)) {
			if (method_exists($item, 'toArray')) {
				$item = $item->toArray();
			}
			else {
				throw new Exception('Iterator item is not an array or item that can be cast to array.');
			}
		}
		
		array_walk($item, array($this, 'prepareField'));
		return implode(',', $item) ."\n";
	}
	
	private function prepareField(&$val, $key) {
		$val = '"'. str_replace('"', '""', $val).'"';
		$val = str_replace("\n", "\r\n", $val);
	}

	public function scaler() {
		return $this->iterator->scaler();
	}
	public function next() {
		$this->iterator->next();
	}
	public function rewind() {
		$this->iterator->rewind();
	}
	public function valid() {
		return $this->iterator->valid();
	}
	public function key() {
		return $this->iterator->key();
	}
	public function __destruct() {
		// Free resources 
	}
}