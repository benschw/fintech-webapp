<?php

class Flfc_DefaultFcChainResolver implements Flfc_ResolvableFcChain {

	private $chain;

	public function __construct(Flfc_App $chain) {
		$this->chain = $chain;
	}

	public function getChain() {
		return $this->chain;
	}
	
	public function canResolve(Flfc_Context $context) {
		return true;
	}

}