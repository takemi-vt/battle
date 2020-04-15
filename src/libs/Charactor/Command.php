<?php
namespace takemi\games\battle\libs\Charactor;

/**
 * コマンド
 */
class Command {
	public const command_none = 0;
	public const command_attack = 1;
	public const command_diffence = 2;
	public const command_charge = 3;
	public const command_magics = 4;

	protected $command = 0;
	protected $magic_command = null;

	public function __construct( int $cmd ) {
		$this->command = $cmd;
	}

	public function SetMagicCommand( int $cmd ) {
		$this->magic_command = new Command( $cmd );
	}

	public function Get() {
		return $this->command;
	}

	public function GetMagic() {
		if( !$this->magic_command ) return self::command_none;
		return $this->magic_command->Get();
	}
}