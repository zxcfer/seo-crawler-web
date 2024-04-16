<?php
class StrFer {

    /**
     * Capatilize first letter of each word of a string.
     *
     * @param string  $value
     * @return string
     */
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE);
    }
	
	public static function urlize($value)
    {
        return str_replace(' ', '-', strtolower($value));
    }
}