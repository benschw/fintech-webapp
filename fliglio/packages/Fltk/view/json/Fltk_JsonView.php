<?php

class Fltk_JsonView implements Flfc_ResponseContent, Flfc_HasHeadersToSet {
	
	private $context;
	protected $data;
	
	public function __construct($data) {
		$this->context = Flfc_Context::get();
		$this->data    = $data;
	}
	
	public function setHeadersOnResponse(Flfc_Response $response) {
		$response->addHeader('Content-Type', 'text/json');
	}
	
	public function render() {
		try {
			$data = $this->data;
			
			return json_encode($data);
			
		} catch (Exception $e) {
			$this->context->getResponse()->setStatus(500);
			
			$err = new Fltk_JsonError("encoding error", 100, $e);
			return $err->render();
		}
	}

	public function toDebugString() {
		return $this->indent($this->render());
	}
	
	/**
	 * http://recursive-design.com/blog/2008/03/11/format-json-with-php/
	 * 
	 * Indents a flat JSON string to make it more human-readable.
	 * 
	 * @param string $json The original JSON string to process.
	 * @return string Indented version of the original JSON string.
	 */
	private function indent($json) {

	    $result      = '';
	    $pos         = 0;
	    $strLen      = strlen($json);
	    $indentStr   = '  ';
	    $newLine     = "\n";
	    $prevChar    = '';
	    $outOfQuotes = true;

	    for ($i=0; $i<=$strLen; $i++) {

	        // Grab the next character in the string.
	        $char = substr($json, $i, 1);

	        // Are we inside a quoted string?
	        if ($char == '"' && $prevChar != '\\') {
	            $outOfQuotes = !$outOfQuotes;

	        // If this character is the end of an element, 
	        // output a new line and indent the next line.
	        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
	            $result .= $newLine;
	            $pos --;
	            for ($j=0; $j<$pos; $j++) {
	                $result .= $indentStr;
	            }
	        }

	        // Add the character to the result string.
	        $result .= $char;

	        // If the last character was the beginning of an element, 
	        // output a new line and indent the next line.
	        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
	            $result .= $newLine;
	            if ($char == '{' || $char == '[') {
	                $pos ++;
	            }

	            for ($j = 0; $j < $pos; $j++) {
	                $result .= $indentStr;
	            }
	        }

	        $prevChar = $char;
	    }

	    return $result;
	}
}