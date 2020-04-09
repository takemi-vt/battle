<?php
/**
 * battle.phpに必要なファイルをインクルード
 */
/*
var_dump( get_include_path() );
echo "\n";

set_include_path( get_include_path(). PATH_SEPARATOR. '.\Charactor' );

var_dump( get_include_path() );
echo "\n";
*/
require_once __DIR__.'\Cui.php';
require_once __DIR__.'\Utils.php';
require_once __DIR__.'\Messagebox.php';
require_once __DIR__.'\Charactor\Chara.php';
require_once __DIR__.'\Charactor\CharaStatus.php';
require_once __DIR__.'\Charactor\Player.php';
require_once __DIR__.'\Charactor\Monster.php';