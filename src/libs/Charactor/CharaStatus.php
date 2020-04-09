<?php
/**
 * 
 */
namespace takemi\games\battle\libs\Charactor;

use JsonSerializable;

/**
 * キャラクターステータス
 */
class CharaStatus implements JsonSerializable{
	/**
	 * @var int	ヒットポイント
	 */
	public $hp;

	/**
	 * @var int	マジックポイント
	 */
	public $mp;

	/**
	 * @var int ストレングス(力)
	 */
	public $str;

	/**
	 * @var int バイタリティ(生命力)
	 */
	public $vit;
	/**
	 * @var int アジリティ(素早さ)
	 */
	public $agi;

	/**
	 * @var int デクステリティ(器用さ)
	 */
	public $dex;

	/**
	 * @var int インテリジェンス(知性)
	 */
	public $int;

	/**
	 * @var int ラック(運)
	 */
	public $luk;

	/**
	 * クリアカウント
	 * @var int
	 */
	public $clr_count;

	/**
	 * ステータス情報を上書き
	 * @param CharaStatus $val
	 * @return void
	 */
	public function Set( CharaStatus $val ) {
		$this->hp = $val->hp;
		$this->mp = $val->mp;
		$this->str = $val->str;
		$this->vit = $val->vit;
		$this->agi = $val->agi;
		$this->dex = $val->dex;
		$this->int = $val->int;
		$this->luk = $val->luk;
	}

	/**
	 * 攻撃力の取得
	 * @return int	攻撃力
	 */
	public function GetAttack() {
		return $this->str + intval( $this->vit * 0.1 );
	}
	
	/**
	 * 防御力の取得
	 * @return int	防御力
	 */
	public function GetDiffence() {
		return $this->vit + intval( $this->str * 0.1 );
	}

	/**
	 * スピードの取得
	 * @return int	素早さ
	 */
	public function GetSpeed() {
		return $this->agi + intval( $this->dex * 0.1 );
	}
	/**
	 * 配列情報を暮らすメンバ変数にセットする
	 * @param array $val
	 * @return void
	 */
	public function SetArray( $data ) {
		$this->hp = $data['hp'];
		$this->mp = $data['mp'];
		$this->str= $data['str'];
		$this->vit= $data['vit'];
		$this->agi= $data['agi'];
		$this->dex= $data['dex'];
		$this->int= $data['int'];
		$this->luk= $data['luk'];
	}

	/**
	 * clr_countをデクリメントして0に成った場合、全ステータス値を0にする
	 * @return boolean
	 */
	public function Clr() {
		$this->clr_count --;
		if( $this->clr_count >= 0 ) return false;
		$this->clr_count = 0;
		$this->hp = 0;
		$this->mp = 0;
		$this->str= 0;
		$this->vit= 0;
		$this->agi= 0;
		$this->dex= 0;
		$this->int= 0;
		$this->luk= 0;
		return true;
	}
	
	/**
	 * データをJSON化
	 * @return array
	 */
	public function jsonSerialize() {
		return (array)$this;
	}

	/**
	 * CharaStatusを加算
	 * @param CharaStatus $val
	 * @return CharaStatus
	 */
	public function Add( CharaStatus $val ) {
		$ret = clone $this;
		$ret->hp += $val->hp;
		$ret->mp += $val->mp;
		$ret->str+= $val->str;
		$ret->vit+= $val->vit;
		$ret->agi+= $val->agi;
		$ret->dex+= $val->dex;
		$ret->int+= $val->int;
		$ret->luk+= $val->luk;
		return $ret;
	}

	/**
	 * CharaStatusを減算処理
	 * @param CharaStatus $val
	 * @return CharaStatus
	 */
	public function Dec( CharaStatus $val ) {
		$ret = clone $this;
		$ret->hp -= $val->hp;
		$ret->mp -= $val->mp;
		$ret->str-= $val->str;
		$ret->vit-= $val->vit;
		$ret->agi-= $val->agi;
		$ret->dex-= $val->dex;
		$ret->int-= $val->int;
		$ret->luk-= $val->luk;
		return $ret;
	}

}