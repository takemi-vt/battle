<?php
namespace takemi\games\battle\libs\Charactor;

use takemi\games\battle\libs\Messagebox;
use takemi\games\battle\libs\Charactor\Command;
use JsonSerializable;

/**
 * キャラクター情報
 */
class Chara implements JsonSerializable{
	/**
	 * @var	string キャラの名前
	 */
	public	$name = "";

	/**
	 * @var	int レベル
	 */
	public	$lv = 0;

	/**
	 * @var	int 経験値
	 */
	public	$exp = 0;

	/**
	 * @var CharaStatus	アクティブステータス
	 */
	public	$status = null;
	/**
	 * @var CharaStatus	戦闘時に発生する±補正のステータス保持用
	 */
	public	$buf_status = null;

	/**
	 * @var array 魔法スロット
	 */
	public $magics = null;

	/**
	 * @var CharaStatus キャラクターのステータス
	 */
	public	$native_status = null;

	public function __construct() {
		$this->status = new CharaStatus();
		$this->buf_status = new CharaStatus();
		$this->native_status = new CharaStatus();
	}

	/**
	 * キャラ情報のJSON文字列取得
	 * @return array
	 */
	public function jsonSerialize () {
		return (array)$this;
	}

	/**
	 * 配列情報からキャラデータを構築
	 */
	public function SetArray( $data ) {
		$this->name = $data['name'];
		$this->lv = $data['lv'];
		$this->exp = $data['exp'];

		if( isset($data['native_status']) ) {
			$this->native_status->SetArray( $data['native_status'] );
			$this->SetLv();
		}
		if( isset( $data['status'] ) ) {
			$this->status->SetArray( $data['status'] );
			if( !isset( $data['native_status']) ) {
				$this->native_status->Set( $this->status );
			}
		} else {
			echo "ファイルフォーマットエラー";
			exit;
		}
		if( $this->status->hp <= 0 ) {
			$this->status->hp = $this->native_status->hp;
			$this->status->mp = $this->native_status->mp;
		}
	}

	/**
	 * @return void
	 */
	public function SetLv() {
		$this->native_status->hp = intval( $this->native_status->vit * 10 + ( $this->native_status->str * 0.1 ) );
		$this->native_status->mp = intval( $this->native_status->int * 10 + ( $this->native_status->vit * 0.1 ) );
	}

	/**
	 * ネイティブステータスを更新
	 * @param CharaStatus $status
	 * @return void
	 */
	public function SetStatus( CharaStatus $status ) {
		$this->native_status = $status;
		$this->ClsStatus();
	}

	/**
	 * アクティブステータスをネイティブでリセット
	 * @return void
	 */
	public function ClsStatus() {
		$this->status->Set( $this->native_status );
	}

	/**
	 * バフステータスのクリア
	 * @return void
	 */
	public function ClsBufStatus() {
		$this->buf_status->Clr();
	}

	public function dump() {
		var_dump( json_encode($this) );
	}

	/**
	 * ユーザの入力したコマンドを実行
	 * @return void
	 */
	public function Command( int $cmd, Chara &$char, Messagebox &$message ) {
		$message->Cls();

		switch( $cmd ) {
			case Command::command_attack : //攻撃
				$this->Attack( $char, $message );
				break;

			case Command::command_diffence : //防御
				$this->Diffence( $char, $message );
				break;

			case Command::command_charge : //ためる
				$this->Chage( $char, $message );
				break;

			case Command::command_magics:
				break;
		}
	}

	/**
	 * 攻撃処理
	 * @param Chara $char
	 * @return void
	 */
	public function Attack( Chara &$char, Messagebox &$message ) {
		//攻撃力取得
		$ap = $this->getAttackPoint();
		//防御力取得
		$df = $char->getDiffencePoint();

		//ダメージ算出
		$dmg = $ap - $df;
		if( $dmg < 0 ) $dmg = 0;

		$char->takeDamege( $dmg );

		$message->Add( $this->name.'の攻撃' );
		$message->display();
		usleep( 500000 );
		$message->Add( "  {$char->name}は {$dmg} のダメージ" );
		$message->display();
		usleep( 500000 );
	}

	/**
	 * 防御処理
	 * @param Chara $char
	 * @param Messagebox $message
	 * @return void
	 */
	public function Diffence( Chara &$char, Messagebox &$message ) {
		$this->buf_status->vit = (int)($this->status->vit * 0.5);
		usleep( 500000 );
		$message->Add( $this->name.'は防御した' );
		$message->display();
		usleep( 500000 );
	}

	/**
	 * ため処理
	 * @param Chara $chara
	 * @param Messagebox $message
	 * @return void
	 */
	public function Chage( Chara &$chara, Messagebox &$message ) {
		$this->buf_status->str += (int)($this->status->str * 0.7);
		$this->buf_status->clr_count ++;
		usleep( 500000 );
		$message->Add( $this->name.'は力をためている' );
		$message->display();
		usleep( 500000 );
	}
	
	public function Magic( Chara $chara, Messagebox &$message ) {

	}
	
	/**
	 * 攻撃時のダメージを取得
	 * @return void
	 */
	public function getAttackPoint() {
		return $this->status->GetAttack() + $this->buf_status->GetAttack();
	}

	/**
	 * 防御力を取得
	 * @return void
	 */
	public function getDiffencePoint() {
		return $this->status->GetDiffence() + $this->buf_status->GetDiffence();
	}

	/**
	 * ダメージ処理
	 * @param integer $dmg
	 * @return void
	 */
	public function takeDamege( int $dmg ) {
		$this->status->hp -= $dmg;
		if( $this->status->hp < 0 ) $this->hp = 0;
	}

	/**
	 * 生死判定
	 * @return boolean
	 */
	public function isAlive() {
		return $this->status->hp > 0;
	}
}