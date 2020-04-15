<?php
namespace takemi\games\battle\libs\Charactor;

use takemi\games\battle\libs\Utils;
use takemi\games\battle\libs\Cui;
use takemi\games\battle\libs\Messagebox;
use takemi\games\battle\libs\Magics\MagicList;

/**
 * プレイヤー情報
 */
class Player extends Chara {

	const player_file = './data/player.json';

	public function __construct()
	{
		parent::__construct();

		$this->magics = new MagicList();
		$this->magics->Load();
	}

	/**
	 * プレイヤー情報の有無の確認
	 * @return boolean
	 */
	public function ExistsPlayer() {
		return file_exists( self::player_file );
	}

	/**
	 * プレイヤー情報の読み込み
	 * @return boolean
	 */
	public function Load() {
		$data = file_get_contents( self::player_file );
		$info = json_decode( $data, true );
		$this->SetArray( $info );
	}

	public function Save() {
		$data = json_encode( $this );

		file_put_contents( self::player_file, $data );
	}

	public function Create( CharaStatus $status ) {
		$this->lv = 1;
		$this->SetStatus( $status );
	}

	/**
	 * キャラクターステータスを表示
	 * @return void
	 */
	public function display() {
		$py_disp_len = strlen( $this->name ) + 4;
		if( $py_disp_len < 11 ) $py_disp_len = 11;

		$bar = Utils::makeBar( $py_disp_len - 2 );

		Cui::locate(0,0);
		echo "┌{$bar}┐\n";
		echo "│ ".str_pad($this->name,$py_disp_len-4)." │\n";
		echo "├{$bar}┤\n";
		echo "│ ".str_pad( "HP:{$this->status->hp}", $py_disp_len-4)." │\n";
		echo "│ ".str_pad( "MP:{$this->status->mp}", $py_disp_len-4)." │\n";
		echo "└ ".str_pad( "Lv:{$this->lv}", $py_disp_len-4, ' ', STR_PAD_BOTH )." ┘\n";
	}

	/**
	 * キャラクターコマンドを表示
	 * @return void
	 */
	public function dispCommnad() {
		$disp_len = 20;
		$bar = Utils::makeBar( $disp_len - 2 );
		$commands = [
			"こうげき",
			"ぼうぎょ",
			"ためる　",
		];

		if( $this->magics->Has() ) {
			$commands[] = "まほう　";
		}

		Cui::locate( 0, Messagebox::con_y );
		echo "┌".Utils::mb_str_pad( "コマンド", ($disp_len*2)-6,"─", STR_PAD_BOTH)."┐\n";
		foreach( $commands as $i => $node ) {
			$node = ($i+1).".".$node;
			echo "│ ".Utils::mb_str_pad( $node, $disp_len-8)." │\n";
		}
		echo "└{$bar}┘\n";
	}

}