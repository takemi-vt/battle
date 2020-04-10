<?php
namespace takemi\games\battle\libs;

/**
 * Enum
 * @link https://qiita.com/Hiraku/items/71e385b56dcaa37629fe
 */
class Enum {
	protected $scalar;

	public function __construct( $value ) {
		$ref = new \ReflectionObject($this);
		$consts = $ref->getConstants();
		if ( !array_key_exists( $value, $consts ) ) {
			throw new \InvalidArgumentException;
		}

		$this->scalar = $consts[$value];
	}

	final public static function __callStatic($label, $args) {
		$class = get_called_class();
		$const = constant("$class::$label");
		return new $class($const);
	}

	//元の値を取り出すメソッド。
	//メソッド名は好みのものに変更どうぞ
	final public function valueOf()
	{
		return $this->scalar;
	}

	final public function __toString()
	{
		return (string)$this->scalar;
	}
}