<?php


/**
 * Generic Response interface so that custom response objects can be created
 *
 * @package Flfc
 */
interface Flfc_ResponseContent {
	public function render();
}

interface Flfc_Streamable {
	public function stream();
}

interface Flfc_HasHeadersToSet {
	public function setHeadersOnResponse(Flfc_Response $response);
}

interface Flfc_ResolvableFcChain {
	public function __construct(Flfc_App $chain);
	public function getChain(); // FlfcApp
	public function canResolve(Flfc_Context $context); // Boolean
}