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
		$this->status = new CharaStatus();
		$this->status->SetArray( (array)$tmp->status );
	}
}