<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('encode'))
{
    function crypt_encode($string)
    {
		$data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
	
	function crypt_decode($string)
	{
		$data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
	}
}