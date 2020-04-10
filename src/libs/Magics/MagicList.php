<?php
namespace takemi\games\battle\libs\Magics;

use takemi\games\battle\libs\Cui;
use takemi\games\battle\libs\Utils;
use takemi\games\battle\libs\Messagebox;
/**
 * キャラが所有する魔法を管理
 */
class MagicList {
	protected $list = [];
	protected const magic_path = "./data/magics/";

	public function __construct() {
	}

	/**
	 * 魔表を表示(メッセージエリアに表示)
	 */
	public function display( Messagebox $message ){
		$message->Cls();
		$message->Add( "魔法を選択してください" );
		for( $n = 0; $n < count($this->list); $n ++ ) {
			$idx = $n + 1;
			$message->Add( " {$idx}. ".$this->list[$n]->name );
		}

		$message->display();
	}

	/**
	 * 魔法を取得
	 */
	public function GetMagic( int $index ) {
		$index --;
		if( isset($this->list[$index]) ) return $this->list[$index];
		return null;
	}

	/**
	 * ディレクトリから魔法情報取得
	 * @return void
	 */
	public function Load(){
		foreach( glob( self::magic_path."*") as $file ) {
			if( $file == "." || $file == ".." ) continue;
			$tmp = new Magic();
			$tmp->Load( $file );
			$this->list[] = $tmp;
		}
	}

	/**
	 * 魔法を持っているかを確認
	 * @return boolean
	 */
	public function Has() {
		return count( $this->list ) ? true : false ;
	}
}