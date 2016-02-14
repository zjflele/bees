<?
include("../include/include.php");
session_destroy();
$js=new javascript();
$js->begin();
$js->GoToUrl("/index.php","top");
$js->end();
?>