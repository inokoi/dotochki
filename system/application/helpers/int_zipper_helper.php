<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
if ( ! function_exists('int_zip')){
    function int_zip($ts, $detail=86400, $min_size=2){
    	$detail = (int)$detail;
    	if($detail<=0){
    		return FALSE;
    	}
    	
    	$ts = floor((int)$ts/$detail);
    	if($ts<=0){
    		return FALSE;
    	}
    	$result = '';
    	while($ts>0){
    		$result.=chr($ts%256);
    		$ts = floor($ts/256);
    	}
    	$result = str_pad($result, $min_size, chr(0), STR_PAD_RIGHT);
    	return $result;
    }
}
if ( ! function_exists('int_unzip')){
    function int_unzip($zipped_data, $detail=86400){
    	$detail = (int)$detail;
    	if($detail<=0){
    		return FALSE;
    	}
    	$result = 0;
    	$multiplier = 1;
    	for($i=0;$i<strlen($zipped_data);$i++){
    		$result+=ord(substr($zipped_data,$i,1))*$multiplier;
    		$multiplier*=256;
    	}
    	return $result*$detail;
    }
}
if ( ! function_exists('strtogmtime')){
    function strtogmtime($str){
        return strtotime($str)+date('Z');
    }
}

?>