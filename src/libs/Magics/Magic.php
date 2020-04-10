<?php
namespace takemi\games\battle\libs\Magics;

use takemi\games\battle\libs\Charactor\CharaStatus;

/**
 * 魔法クラス
 */
class Magic {
	/**
	 * @var string 魔法名
	 */
	public $name = "";

	/**
	 * @var MagicAttribute 魔法属性
	 */
	public $attribute = null;

	/**
	 * @var MagicType 魔法タイプ
	 */
	public $type = null;

	/**
	 * @var CharaStatus 効果ステータス
	 * @var [type]
	 */
	public $status = null;

	public $damage = 0;

	/**
	 * JSONファイルから読み込み
	 * @param string $path
	 * @return void
	 */
	public function Load( string $path ){
		$tmp = json_decode( file_get_contents($path) );
		$this->name = $tmp->name;
		$this->type = new MagicType( $tmp->type );
		$this->attribute = new MagicAttribute( (array)$tmp->attribute );
		$this->damage = $tmp->damage ?? 0;
		$this->status = new CharaStatus();
		$this->status->SetArray( (array)$tmp->status );
	}

	/**
	 * 魔法処理
	 * @param Chara $src
	 * @param Chara $trg
	 * @param Messagebox $messagebox
	 * @return void
	 */
	public function Command( Chara $src, Chara $trg, Messagebox $messagebox ) {
		$messagebox->Add( $this->name.'を唱えた！' );
		usleep( 50000 );
		switch( $this->type ) {
			case MagicType::attack:
				$src->status->hp -= $this->damage;
				$messagebox->Add( $trg->name.'に'.$this->damage.'のダメージ' );
				break;

			case MagicType::recovery:
				$src->status->hp += $this->status->hp;
				if( $src->status->hp > $src->native_status->hp ) $src->status->hp = $src->native_status->hp;
				$messagebox->Add( $src->name.'は回復した' );
				break;
			
			case MagicType::status:
				break;
		}
		usleep( 50000 );
	}
}