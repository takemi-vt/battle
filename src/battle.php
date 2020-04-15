<?php
/**
 * CUIモンスターバトルゲーム
 * @author  takemi <takemi.vtuber@gmail.com>
 */
namespace takemi\games\battle;

use takemi\games\battle\libs\Charactor\CharaStatus;
use takemi\games\battle\libs\Charactor\Command;
use takemi\games\battle\libs\Charactor\Monster;
use takemi\games\battle\libs\Charactor\Player;
use takemi\games\battle\libs\Cui;
use takemi\games\battle\libs\Messagebox;

require_once './libs/include.php';


$args_monster_id = null;

Cui::cls();

echo "> アプリケーションを起動します...\n";
echo "> CUI引数処理を実施\n";
args_proc();
echo "> データをロード\n";
$player = new Player();

echo "> プレイヤーデータの確認\n";
//プレイヤー情報の確認
if( $player->existsPlayer() ) {
	echo "	プレイヤーデータを確認しました\n";
	//プレイヤー情報のロード
	$player->Load();
	usleep( 500000 );
	Cui::cls();
	echo "> おかえりなさい。{$player->name}\n";

} else {
	echo "	プレイヤーデータは確認できませんでした\n";
	//プレイヤー情報の作成
	makePlayer();
	usleep( 500000 );
	Cui::cls();
	echo "> はじめまして。{$player->name}\n";
}

usleep( 500000 );
echo "> さっそくモンスターが現れました。\n";
usleep( 500000 );
battle();
exit;

/**
 * プレーヤー情報の作成
 * @return void
 */
function makePlayer() {
	Global $player;

	echo "> プレーヤー情報を作成します\n";
	echo "	プレイヤーの名前を入力してください\n";
	echo "	プレイヤー名：";

	$input = trim( fgets(STDIN) );

	$player->name = $input;
	$loop_flag = true;
	$point = 50;
	$status = new CharaStatus();
	while( $loop_flag ) {
		echo "\n";
		echo "> ステータスポイントの割り振りを行ってください。\n";
		echo "	所有ステータスポイント：{$point}\n";
		$status->str = InputNumber( '           STR(力):', true, $point );
		$point -= $status->str;
		Cui::lineup(2);
		Cui::right(40);
		echo "{$point} ";
		Cui::linedown(2);
		Cui::linecls();

		$status->vit = InputNumber( '           VIT(生命力):', true, $point );
		$point -= $status->vit;
		Cui::lineup(3);
		Cui::right(40);
		echo "{$point} ";
		Cui::linedown(3);
		Cui::linecls();

		$status->agi = InputNumber( '           AGI(素早さ):', true, $point );
		$point -= $status->agi;
		Cui::lineup(4);
		Cui::right(40);
		echo "{$point} ";
		Cui::linedown(4);
		Cui::linecls();

		$status->dex = InputNumber( '           DEX(器用さ):', true, $point );
		$point -= $status->dex;
		Cui::lineup(5);
		Cui::right(40);
		echo "{$point} ";
		Cui::linedown(5);
		Cui::linecls();

		$status->int = InputNumber( '           INT(知性):', true, $point );
		$point -= $status->int;
		Cui::lineup(6);
		Cui::right(40);
		echo "{$point} ";
		Cui::linedown(6);
		Cui::linecls();

		$status->luk = InputNumber( '           LUK(運):', true, $point );
		$point -= $status->luk;
		Cui::lineup(7);
		Cui::right(40);
		echo "{$point} ";
		Cui::linedown(7);
		Cui::linecls();

		if( $point > 0 ) {
			echo "> ポイントが残っています割り振りし直しますか？\n";
			echo "	[Y/y] 割り振り直し [N/n]そのまま : ";
			$input = trim( fgets(STDIN) );
			if( strtolower($input) == 'y' ) {
				$point = 50;
				Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				continue;
			}
			break;
		} else {
			echo "> このステータス値でよろしいですか？\n";
			echo "	[Y/y] OK [N/n]やり直す: ";
			$input = trim( fgets(STDIN) );
			if( strtolower($input) != 'y' ) {
				$point = 50;
				Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				Cui::lineup(1); Cui::linecls();
				continue;
			}
			break;
		}
	}

	$player->create( $status );
	$player->Save();
	echo "> プレーヤー情報の作成が完了しました。\n";
}

/**
 * 数値入力 
 * @param string $caption	入力時に表示する文字列
 * @param boolean $required	必須フラグ
 * @param input $max		入力最大位置
 * @return void
 */
function InputNumber( $caption, $required = false , $max = false, $min = 0 ) {
	$loop_flag = true;

	while( $loop_flag ) {
		Cui::linecls();
		echo $caption;
		$input = trim( fgets(STDIN) );

		//必須判定
		if( $required === true ) {
			if( $input == "" ) {
				Cui::strColor( " ERROR:数値を入力してください\n", 'light-red' );
				Cui::lineup(2);
				continue;
			}
		}

		//数値判定
		if( ctype_digit($input) === false ) {
			Cui::strColor( " ERROR:数値を入力してください\n", 'light-red' );
			Cui::lineup(2);
			continue;
		}

		$tmp = intval($input);
		//最大値判定
		if( $max !== false && $tmp > $max ) {
			Cui::strColor( " ERROR:{$max}以下の値で入力してください\n", 'light-red' );
			Cui::lineup(2);
			continue;
		}

		//最小値判定
		if( $min !== false && $min > $tmp ) {
	 		Cui::strColor( " ERROR:{$min}以上の値で入力してください\n", 'light-red' );
			Cui::lineup(2);
			continue;
		}
		$loop_flag = false;
		break;
	}

	return intval( $input );
}

function battle() {
	Global $player;
	Global $args_monster_id;

	//モンスターデータをロード
	$monster = new Monster();

	//モンスターをロード
	if( $args_monster_id ) {
		//引数指定がある場合は適応する
		$monster->Load( $args_monster_id );
	} else {
		$monster->Load( 1 );
	}

	$message = new Messagebox();
	$loop = true;

	while( $loop ) {
		Cui::cls();
		//主人公表示
		$player->display();

		//モンスター表示
		$monster->display();

		//コマンド表示
		$player->dispCommnad();

		$message->Add('コマンドを入力してください');
		$message->display();
		echo "\n";
		$player->Command( getCommand( $player, $message ), $monster, $message );
		if( $monster->isAlive() == false ) {
			$loop = false;
			$player->display();
			usleep( 30000 );
			$message->Add("");
			$message->Add("{$monster->name}を倒した！！！！");
			$message->display();
			break;
		}
		usleep( 100000 );
		$cmd = rand(1,3);
		$monster->Command( new Command( $cmd ), $player, $message );
		if( $player->isAlive() == false ) {
			$player->display();
			$loop = false;
			usleep( 30000 );
			$message->Add("");
			$message->Add("{$player->name}は倒れた！！！！");
			$message->display();
			break;
		}

		$player->ClsBufStatus();
		$monster->ClsBufStatus();
	}
}

/**
 * ユーザからのコマンドを受け付ける
 * @return Command
 */
function getCommand( Player $player, Messagebox $message ) {
	$loop = true;
	$max = 3;
	if( $player->magics->Has() ) {
		$max = 4;
	}
	$cmd = 0;
	while( $loop ) {
		$cmd = trim( fgets( STDIN ) );
		if( 1 <= $cmd && $cmd <= $max ) break;
		Cui::strColor( "1 - {$max} の間の数値を入力してください", 'red');
		Cui::LineUp( 1 );
	}
	$command = new Command($cmd);
	//魔法の場合
	if( $cmd == 4 ) {
		$max = $player->magics->Has() + 1;
		$mag = 0;
		while( $loop ) {
			$player->magics->display( $message );
			$mag = trim( fgets( STDIN ) );
			if( 1 <= $mag && $mag <= $max ) break;
			Cui::strColor( "1 - {$max} の間の数値を入力してください", 'red');
			Cui::LineUp( 1 );
		}
		$command->SetMagicCommand( intval($mag) );
	}
	return $command;
}

/**
 * 引数処理
 * @return void
 */
function args_proc() {
	Global $argv;
	Global $args_monster_id;
	if( count($argv) == 0 ) return;

	for( $n = 0; $n < count($argv); $n ++ ){
		if( !isset( $argv[$n] ) ) break;
		switch( $argv[$n] ) {
			case '-m':
				$n ++;
				$args_monster_id = $argv[$n] ?? null;
				break;
		}
	}
}