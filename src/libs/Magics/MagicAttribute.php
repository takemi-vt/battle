<?php
namespace takemi\games\battle\libs\Magics;

use takemi\games\battle\libs\Enum;

/**
 * 魔法属性クラス
 */
class MagicAttribute {

	/**
	 * @var int 無属性(物理)
	 */
	public $void = 0;

	/**
	 * @var int 火属性
	 */
	public $flame = 0;

	/**
	 * @var int 水属性
	 */
	public $water = 0;

	/**
	 * @var int 風属性
	 */
	public $wind = 0;

	/**
	 * @var int 土属性
	 */
	public $earth = 0;

	/**
	 * コンストラクタ
	 * @param array $val
	 */
	public function __construct( $val = []) {
		if( $val ) {
			$this->SetArray( $val );
		}
	}

	/**
	 * 配列から要素をセット
	 * @param array $val
	 * @return void
	 */
	public function SetArray( array $val ) {
		$this->void = $val['void'] ?? 0;
		$this->flame = $val['flame'] ?? 0;
		$this->water = $val['water'] ?? 0;
		$this->wind = $val['wind'] ?? 0;
		$this->earth = $val['earth'] ?? 0;
	}
}