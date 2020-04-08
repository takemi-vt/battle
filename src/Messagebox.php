<?php
namespace takemi\games\battle;

class Messagebox {
	protected const con_x = 21;
	protected const con_y = 11;
	protected const width = 40;
	protected const height=6;

	protected $list = [];

	public function display(){
		$bar = Utils::makeBar( 40 );
		Cui::locate(21,11); echo "┌{$bar}┐";
		for( $n = 1; $n <= self::height; $n ++ ) {
			$space = "";
			if( isset($this->list[$n-1]) ) {
				$space= $this->list[$n-1];
			}
			Cui::locate( self::con_x, self::con_y + $n );
			Cui::lineCls();
			echo "│{$space}";
			Cui::locate( self::con_x + self::width + 1, self::con_y + $n); echo "│";
		}
		Cui::locate(21,18); echo "└{$bar}┘";
	}
	
	public function Add( string $str ) {
		$this->list[] = $str;
		if( count( $this->list) > self::height ) {
			array_shift( $this->list );
		}
	}

	public function Cls() {
		$this->list = [];
	}

}