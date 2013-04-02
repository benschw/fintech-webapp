<?php

class Fliglio_BuildTools_ParserCollector extends PHPParser_NodeVisitorAbstract {

	private $file;
	
	private $classes = array();
	
	public function __construct($file) {
		$this->file = $file;
	}
	public function getFile() {
		return $this->file;
	}
	
	public function getClasses() {
		return $this->classes;
	}

	public function enterNode(PHPParser_Node $node) {
		// echo $this->nodeDumper->dump($node);
		if ($node instanceof PHPParser_Node_Stmt_Class || $node instanceof PHPParser_Node_Stmt_Interface) {
			$this->classes[] = $node->name;
		}
	}
}
