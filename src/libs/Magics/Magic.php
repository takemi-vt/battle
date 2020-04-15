<?php
namespace takemi\games\battle\libs\Magics;

use takemi\games\battle\libs\Messagebox;
use takemi\games\battle\libs\Charactor\Chara;
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

	/**
	 * 魔法ダメージ
	 * @var integer
	 */
	public $damege = 0;

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
		$this->damege = $tmp->damege ?? 0;
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
		$src->status->mp += $this->status->mp;
		$messagebox->Add( "{$src->name}は {$this->name} を唱えた！" );
		$messagebox->display();
		usleep( 50000 );

		switch( $this->type->valueOf() ) {
			case MagicType::attack:
				$trg->status->hp -= $this->damege;
				$messagebox->Add( $trg->name.'に'.$this->damege.'のダメージ' );
				break;

			case MagicType::recovery:
				$src->status->hp += $this->status->hp;
				if( $src->status->hp > $src->native_status->hp ) $src->status->hp = $src->native_status->hp;
				$messagebox->Add( $src->name.'は回復した' );
				break;
			
			case MagicType::status:
				break;
		}
		$messagebox->display();
		usleep( 50000 );
	}
}