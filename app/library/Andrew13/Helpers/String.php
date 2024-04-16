<?php namespace Andrew13\Helpers;

use Carbon\Carbon;
use tidy;

class String {

    /**
     * Capitilize first letter of each word of a string.
     *
     * @param string  $value
     * @return string
     */
    public static function title($value) {
        return mb_convert_case($value, MB_CASE_TITLE);
    }
	
	public static function urlize($value) {
        return str_replace(' ', '-', strtolower($value));
    }
	
	public static function titleize($value) {
		$no_dashes = str_replace('-', ' ', $value);
		$clean = str_replace('_', ' ', $no_dashes);
        return mb_convert_case($clean, MB_CASE_TITLE);
    }

	/**
	 * clean table name
	 * TODO: exepction if not match [a-z0-9_]
	 * @param string $field
	 * @return string
	 */
	public static function quoteIdentifier($field) {
		$no_dashes = str_replace('-', '_', $field);
		$no_spaces = str_replace(' ', '_', $no_dashes);
		return str_replace("`","``",$no_spaces);
	}
	
	/**
     * @param $value
     * @internal param $html
     * @return string
     */
    public static function tidy($value)
    {
        // Check to see if Tidy is available.
        if(class_exists('tidy')) {
            $tidy = new tidy();
            return  $tidy->repairString($value, array(
                'show-body-only' => true,
            ));
        } else { // No Tidy, Time for regex and possibly a broken DOM :(
            preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $value, $result);
            $openedtags = $result[1];
            preg_match_all('#</([a-z]+)>#iU', $value, $result);
            $closedtags = $result[1];
            $len_opened = count($openedtags);
            if (count($closedtags) == $len_opened) {
                return $value;
            }
            $openedtags = array_reverse($openedtags);
            for ($i=0; $i < $len_opened; $i++) {
                if (!in_array($openedtags[$i], $closedtags)) {
                    $value .= '</'.$openedtags[$i].'>';
                } else {
                    unset($closedtags[array_search($openedtags[$i], $closedtags)]);
                }
            }
            return $value;
        }
    }

    public static function date(Carbon $date)
    {
        if($date->diffInDays(Carbon::now()) < 7) {
            return $date->diffForHumans();
        } else {
            return $date->toFormattedDateString();
        }
    }

}
