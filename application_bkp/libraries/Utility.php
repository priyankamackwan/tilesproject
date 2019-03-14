<?php
class Utility
{
	var $skey 	= "api"; // you can change it
	public  function safe_b64encode($string)
	 {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

	public function safe_b64decode($string)
	 {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4)
		 {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
	 public  function encode($value)
	 {

	    if(!$value){return false;}
        $text = $value;

        return trim($this->safe_b64encode($text));
    }

    public function decode($value)
	{

        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value);

        return trim($crypttext);
    }
}
?>