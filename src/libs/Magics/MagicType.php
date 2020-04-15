<?php
namespace takemi\games\battle\libs\Magics;

use takemi\games\battle\libs\Enum;
/**
 * 魔法の処理タイプ
 */
class MagicType extends Enum {
	/**
	 * 回復
	 */
	public const recovery = 1;

	/**
	 * 攻撃
	 */
	public const attack = 2;

	/**
	 * ステータス向上(バフ)
	 */
	public const status = 3;
}	