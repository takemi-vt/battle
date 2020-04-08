<?php
namespace takemi\games\battle;

/**
 * CUI制御クラス
 */
class Cui
{
	public static function cls() {
		echo "\033[;H\033[2J";
	}

	/**
	 * n行上の行先頭に移動
	 * @param integer $n
	 * @return void
	 */
	public static function lineUp( int $n ) {
		echo "\e[{$n}F";
	}

	public static function lineDown( int $n ) {
		echo "\e[{$n}E";
	}
	/**
	 * カーソル行を削除(mode=0:カーソルより後ろを削除/mode=1:カーソルより前を削除/mode=2行全体を削除)
	 */
	public static function lineCls( int $mode = 0) {
		echo "\e[{$mode}K";
	}

	/**
	 * 左に$n移動する
	 * @param integer $n
	 * @return void
	 */
	public static function left( int $n ) {
		echo "\e[{$n}D";
	}

	/**
	 * 右に$n移動する
	 * @param integer $n
	 * @return void
	 */
	public static function right( int $n ) {
		echo "\e[{$n}C";
	}

	/**
	 * 色付きテキストを出力
	 * @param string $str
	 * @param string $color
	 * @return void
	 */
	public static function strColor( $str, $color ) {
		switch( strtolower($color) ) {
			case 'black' :
				echo "\033[0;30m{$str}\033[0m";
				break;

			case 'blue' :
				echo "\033[0;34m{$str}\033[0m";
				break;

			case 'green' :
				echo "\033[0;32m{$str}\033[0m";
				break;

			case 'cyan' :
				echo "\033[0;36m{$str}\033[0m";
				break;

			case 'red' :
				echo "\033[0;31m{$str}\033[0m";
				break;

			case 'purple' :
				echo "\033[0;35m{$str}\033[0m";
				break;

			case 'brown' :
				echo "\033[0;33m{$str}\033[0m";
				break;
			
			case 'light-gray' :
				echo "\033[0;37m{$str}\033[0m";
				break;

			case 'dark-gray' :
				echo "\033[1;30m{$str}\033[0m";
				break;
			
			case 'light-blue':
				echo "\033[1;34m{$str}\033[0m";
				break;

			case 'light-green':
				echo "\033[1;32m{$str}\033[0m";
				break;

			case 'light-cyan':
				echo "\033[1;36m{$str}\033[0m";
				break;

			case 'light-red':
				echo "\033[1;31m{$str}\033[0m";
				break;
		}
	}

	public static function strRGB( $caption, int $r, int $g, int $b ){
		echo "\033[38;2;{$r};{$g};{$b}m{$caption}\033[0m";
	}

	public static function locate( int $x, int $y ) {
		echo "\033[{$y};{$x}H";
	}
}