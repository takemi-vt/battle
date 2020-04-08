<?php
namespace takemi\games\battle;

/**
 * ユーティリティー
 */
class Utils {
	/**
	 * マルチバイト用str_pad
	 * @url https://qiita.com/tksnino/items/7188b95ea7f8e3a3b8dc
	 * @param [type] $input
	 * @param [type] $pad_length
	 * @param string $pad_string
	 * @param [type] $pad_style
	 * @param string $encoding
	 * @return void
	 */
	public static function mb_str_pad ($input, $pad_length, $pad_string=" ", $pad_style=STR_PAD_RIGHT, $encoding="UTF-8") {
		$mb_pad_length = strlen($input) - \mb_strlen($input, $encoding) + $pad_length;
		return str_pad($input, $mb_pad_length, $pad_string, $pad_style);
	}

	public static function makeBar( $len, $def = "─" ) {
		$ret = "";
		for( $n = 0; $n < $len; $n ++ ) $ret .= $def;
		return $ret;
	}
}