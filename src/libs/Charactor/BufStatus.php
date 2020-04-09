<?php
namespace takemi\games\battle\libs\Charactor;

use takemi\games\battle\libs\Charactor\CharaStatus;

/**
 * 複数バフステータス管理クラス
 */
class BufStatus {
	protected $list = [];

	public function __construct() {
		
	}

	public function add( CharaStatus $status ) {
		$this->list[] = $status;
	}

	/**
	 * 期限切れのステータスを削除
	 * @return void
	 */
	public function Clr(){
		for( $n = 0; $n < count($this->list); $n ++ ) {
			if( $this->list[$n]->Clr() === false ) {
				unset( $this->list[$n] );
			}
		}
		array_values( $this->list );
	}

	/**
	 * サマリステータスの取得
	 * @return CharaStatus
	 */
	public function GetStatus(){
		$ret = new CharaStatus();
		foreach( $this->list as $v ){
			$ret = $ret->Add( $v );
		}
		return $ret;
	}
}