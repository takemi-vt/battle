<?php
namespace takemi\games\battle\libs\Magics;

use takemi\games\battle\libs\Enum;

/**
 * 魔法属性クラス
 */
class MagicAttribute extends Enum {
	/**
	 * 火属性
	 */
	const flame = 1;
	/**
	 * 水属性
	 */
	const water = 2;

	/**
	 * 風属性
	 */
	const wind = 3;

	/**
	 * 土属性
	 */
	const earth = 4;
}