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
require_once '.\Cui.php';
require_once '.\Utils.php';
require_once '.\Messagebox.php';
require_once '.\Charactor\Chara.php';
require_once '.\Charactor\CharaStatus.php';
require_once '.\Charactor\Player.php';
require_once '.\Charactor\Monster.php';