<?php
function curlPost($url, $params)
{
	if (empty($url)) {		
		return false;
	}
	
	if (is_array($params)) {
		$tmp = '';
		foreach($params as $key => $value) {
			if (!empty($tmp)) {
				$tmp .= '&';
			}
			$tmp .= rawurlencode($key) . '=' . rawurlencode($value);
		}
		$params = $tmp;
	}
	
	if (($params == null) || empty($params)) {
		return false;
	}
	
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
	curl_setopt($curl, CURLOPT_POST, 1); 
	curl_setopt($curl, CURLOPT_POSTFIELDS, $params); 
	$result = curl_exec($curl);
	
	return $result;
}
