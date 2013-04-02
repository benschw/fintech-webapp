<?php
/**
 * Closure View 
 * - Default data return for closure framework
 *
 * @package Fltk
 */
class Fltk_ClosureView implements Flfc_ResponseContent, Flfc_HasHeadersToSet {

	/** Standard Status Codes */
	const SUCCESS                = 0; // Generic Success
	const WARNING                = 1; // Generic Warning
	const ERROR                  = 2; // Process error
	const INFO                   = 3; // Generic Message
	const MISSING_FIELDS         = 4; // Missing Input
	const BAD_INPUT              = 5; // Bad input
	const UNAUTHENTICATED        = 6; // Unauthenticated User

	const SUCCESS_VERBOSE        = 7;
	const WARNING_VERBOSE        = 8;
	const ERROR_VERBOSE          = 9;
	const INFO_VERBOSE           = 10;
	const MISSING_FIELDS_VERBOSE = 11;
	const BAD_INPUT_VERBOSE      = 12;
	const LOADING                = 13;
	const UNAUTHORIZED           = 14; // Permission/Authorization not found
	const CONFIRM                = 15; // Permission/Authorization not found

	/**
	 * @var array
	 */
	private static $statusCodes = array(
			self::SUCCESS                => 'Success',
			self::WARNING                => 'Warning',
			self::ERROR                  => 'Error',
			self::INFO                   => 'Information',
			self::MISSING_FIELDS         => 'Missing Input',
			self::BAD_INPUT              => 'Bad Input',
			self::UNAUTHENTICATED        => 'You are not logged in',
			self::SUCCESS_VERBOSE        => 'Success',
			self::WARNING_VERBOSE        => 'Warning',
			self::ERROR_VERBOSE          => 'Error',
			self::INFO_VERBOSE           => 'Information',
			self::MISSING_FIELDS_VERBOSE => 'Missing Input',
			self::BAD_INPUT_VERBOSE      => 'Bad Input',
			self::UNAUTHORIZED           => 'You are not authorized',
			self::CONFIRM                => 'Confirm'
		);

	/**
	 * @var Flfc_Context
	 */
	private $context;

	/**
	 * @var int
	 */
	private $statusCode;

	/**
	 * @var string
	 */
	private $message;
	
	/**
	 * @var string
	 */
	private $debug;
	
	/**
	 * @var mixed
	 */
	protected $data;

	public function __construct($statusCode, $data = null, $message = null, $debug = null) {
		if (!isset(self::$statusCodes[$statusCode])) {
			throw new Exception("Status code, $statusCode, not found");
		}

		$this->context    = Flfc_Context::get();
		$this->statusCode = $statusCode;
		$this->message    = $message;
		$this->data       = $data;
		$this->debug      = $debug;
	}
	
	public function getData() {
		return $this->data;
	}

	public function setHeadersOnResponse(Flfc_Response $response) {
		$response->addHeader('Content-Type', 'text/json');
	}

	public function render() {
		$result = null;

		try {
			$data = array(
					'status'  => $this->statusCode,
					'content' => $this->data,
					'message' => $this->message,
					'debug'   => null
				);

			if (Fl_Core_Config::get()->debug) {
				if (!is_null($this->debug)) {
					$data['debug'] = $this->debug;
				} else {
					// $data['debug'] = FlMon_Logging_TmpLog::get()->toArray();
				}
			}

			$result = json_encode($data);

		} catch (Exception $e) {
			$this->context->getResponse()->setStatus(500);
			$err = new Fltk_JsonError("encoding error", 100, $e);
			$result = $err->render();
		}

		return $result;
	}
}