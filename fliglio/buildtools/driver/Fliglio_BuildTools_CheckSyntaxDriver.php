<?php

class Fliglio_BuildTools_CheckSyntaxDriver {

	public static function main(array $config) {
		$files = $config['files'];
		$paths = $config['paths'];

		try {
			foreach ($paths as $path) {
				$output = array();
				$findCmd = 'find "'.$path.'" -type f -name \*.php 2>&1';
			
				exec($findCmd, $output, $ret);
				if ($ret != 0) {
					throw new Exception("Command Failed: " . implode("\n", $output));
				}
				$files = array_merge($files, $output);
			}
			
			$fail = false;
			foreach ($files as $file) {
				$output = array();
				$lintCmd = 'php -l "'.$file.'" 2>/dev/null';
				exec($lintCmd, $output, $ret);
				if ($ret != 0 && empty($output)) {
					throw new Exception("Command Failed: " . $lintCmd);
				}
				$output = implode("\n", $output);
				$syntaxError = preg_replace("/Errors parsing.*$/", "", $output, -1, $count);
				if($count > 0) {
					$fail = true;
					print trim($syntaxError) . "\n";
				}
			}

			if ($fail) {
				exit(1);
			}
		} catch (Exception $e) {
			echo $e->getMessage() . "\n";
			exit(1);
		}
	}
}