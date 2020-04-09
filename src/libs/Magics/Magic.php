<?php
namespace takemi\games\battle\libs\Magics;
/**
 * 魔法
 */
class Magic {
	/**
	 * @var string 魔法名
	 */
	public $name;

	/**
	 * @var MagicAttribute 魔法属性
	 */
	public $attribute;

	/**
	 * @var MagicType 魔法タイプ
	 */
	public $type;
}