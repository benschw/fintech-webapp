<?php

class Util_Storage_StorageCoordinator {
	
	private $cleanStorage;
	private $rawStorage;

	public function __construct( $namespace, $storage, $rawProps ) {
		$this->cleanStorage = Util_Storage_CleanStorage::get( $storage, $namespace );
		$this->rawStorage   = Util_Storage_RawStorage::get( $storage, $namespace, $rawProps );
	}

	public function getCleanStorage() { return $this->cleanStorage; }
	public function getRawStorage() {   return $this->rawStorage; }


	public function getProp( $key ) {
		if( isset( $this->getRawStorage()->{$key} ) ) {
			return $this->getRawStorage()->{$key};
		} else if( isset( $this->getCleanStorage()->{$key} ) ) {
			return $this->getCleanStorage()->{$key};
		} else {
			return null;
		}
	}

	public function setValidatedProp( $key ) {
		if( isset( $this->getRawStorage()->{$key} ) ) {

			$this->getCleanStorage()->{$key} = $this->getRawStorage()->{$key};
			unset( $this->getRawStorage()->{$key} );
		}
	}
	public function unsetValidatedProp( $key ) {
		unset( $this->getCleanStorage()->{$key} );
	}


	public function isPropSet( $key ) {
		return isset( $this->getRawStorage()->{$key} ) || isset( $this->getCleanStorage()->{$key} );
	}


}