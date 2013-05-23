<?php
// compatibility for PHP < 5.2

// json support
if (! extension_loaded('json')) {
	require_once 'Services/JSON.php';
	if (!function_exists('json_decode')){
		function json_decode($content, $assoc=false) {
			$json = $assoc?new Services_JSON(SERVICES_JSON_LOOSE_TYPE):new Services_JSON;
			return $json->decode($content);
		}
	}
	if (!function_exists('json_encode')){
		function json_encode($content){
			$json = new Services_JSON;
			return $json->encode($content);
		}
	}
}

if(!function_exists('parse_ini_string')){
	function parse_ini_string($str, $ProcessSections=false){
		$lines  = explode("\n", $str);
		$return = Array();
		$inSect = false;
		foreach($lines as $line){
			$line = trim($line);
			if(!$line || $line[0] == '#' || $line[0] == ';')
				continue;
			if($line[0] == '[' && $endIdx = strpos($line, ']')){
				$inSect = substr($line, 1, $endIdx-1);
				continue;
			}
			if(!strpos($line, '=')) {// (We don't use "=== false" because value 0 is not valid as well)
				$return = false;
				break;
			}
			 
			$tmp = explode('=', $line, 2);
			$key = trim($tmp[0]);
			$arrayKey = null;
			
			if (preg_match('/^([^\[\]]+)\[([^\]]*)\]$/', $key, $_match)) {
				$key = $_match[1];
				$arrayKey = $_match[2];
			}
			
			if (preg_match('/[?{}|&~!\[()\^"]/', $key)) continue;
			
			if ($key) {
				$val = ltrim($tmp[1]);
				$val = preg_replace('/^"(.*)"$/', '$1', $val);
				if($ProcessSections && $inSect) {
					if (is_null($arrayKey)) {
						$return[$inSect][$key] = $val;
					} else {
						if ($arrayKey !== '') {
							$return[$inSect][$key][$arrayKey] = $val;
						} else {
							$return[$inSect][$key][] = $val;
						}
					}
				} else {
					if (is_null($arrayKey)) {
						$return[$key] = $val;
					} else {
						if ($arrayKey !== '') {
							$return[$key][$arrayKey] = $val;
						} else {
							$return[$key][] = $val;
						}
					}
				}
			}
		}
		return $return;
	}
}
