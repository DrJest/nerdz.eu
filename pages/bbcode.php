<?php
$lang = $core->isLogged() ? $core->getUserLanguage($_SESSION['nerdz_id']) : $core->getBrowserLanguage();

$vals = array();
$vals['bbcode_n'] = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/tpl/{$core->getTemplate()}/langs/{$lang}/bbcode.html");

require_once $_SERVER['DOCUMENT_ROOT'].'/pages/common/vars.php';
$core->getTPL()->assign($vals);
$core->getTPL()->draw('base/bbcode');
?>
