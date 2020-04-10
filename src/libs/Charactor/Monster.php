<?php
namespace takemi\games\battle\libs\Charactor;

use takemi\games\battle\libs\Cui;

class Monster extends Chara {
	const monster_path = "./data/";

	protected $disp = [];
	protected $disp_color = [];
	/**
	 * モンスター表示処理
	 * @return void
	 */
	public function display() {

		foreach( $this->disp as $node ) {
			echo "     ";
			if( $this->disp_color ) {
				Cui::strRGB( $node, $this->disp_color['r'], $this->disp_color['g'], $this->disp_color['b']);
				echo "\n";
			}
			else { 
				echo $node."\n";
			}
		} 
		echo "\n";
		echo "     ";
		if( $this->disp_color ) {
			Cui::strRGB( $this->name, $this->disp_color['r'], $this->disp_color['g'], $this->disp_color['b']);
			echo "\n";
		} else {
			echo $this->name;
		}
	}

	/**
	 * モンスター情報読み込み
	 * @return void
	 */
	public function Load( $num ) {
		$path = self::monster_path."monster".str_pad( $num, 2, "0", STR_PAD_LEFT ).".json";
		$data = json_decode( file_get_contents($path), true );
		$this->SetArray( $data );
		$this->disp = $data['display'];
		$this->disp_color = $data['disp-color'] ?? [];
	}
}