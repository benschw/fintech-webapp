<?php
/**
 * Nested Result Set
 *
 * @package Util.Db
 */
class Util_Db_NestedResultSet implements Iterator {
	
	private $results;
	private $idColumn;
	private $groupByColumn;
	private $index = 0;
	
	public function __construct( Iterator $results, $idColumn, $groupByColumn ) {
		$this->results = $results;
		$this->idColumn = $idColumn;
		$this->groupByColumn = $groupByColumn;
	}
	
	/**
	 * Get all items as an array.
	 *
	 * @return array
	 */
	public function all() {
		$r = array();
		foreach ( $this as $row ) {
			$r[] = $row;
		}
		return $r;
	}
	
	public function current() {
		$row = $this->results->current();
		$row->children = array();
		$id = $row->{$this->idColumn};
		
		if ( is_null($row->{$this->groupByColumn}) ) {
			// this item has no children
			$this->results->next();
		}
		else {
			do {
				$child = $this->results->current();
			
				if ( $child->{$this->groupByColumn} === $id ) {
					$row->children[] = $child;
			
					$this->results->next();
				}
				else {
					break;
				}
			} while ( $this->results->valid() );
		}
		
		return $row;
	}
	
	public function key() {
		return $this->index;
	}
	
	public function next() {
		++$this->index;
	}
	
	public function valid() {
		return $this->results->valid();
	}
	
	public function rewind() {
		$this->results->rewind();
	}
}