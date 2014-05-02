<?php
ob_start('ob_gzhandler');
require_once $_SERVER['DOCUMENT_ROOT'].'/class/core.class.php';

$core = new phpCore();

if(!$core->refererControl())
    die($core->jsonResponse('error',$core->lang('ERROR').': referer'));
    
if(!$core->csrfControl(isset($_POST['tok']) ? $_POST['tok'] : 0,'edit'))
    die($core->jsonResponse('error',$core->lang('ERROR').': token'));
    
if(!$core->isLogged())
    die($core->jsonResponse('error',$core->lang('REGISTER')));;
    
$id = $_SESSION['nerdz_id'];
    
if(!($obj = $core->query(array('SELECT "private" FROM "users" WHERE "counter" = ?',array($id)),db::FETCH_OBJ)))
    die($core->jsonResponse('error',$core->lang('ERROR')));

switch(isset($_GET['action']) ? strtolower($_GET['action']) : '')
{
    case 'public':
        if($obj->private == 1)
            if(db::NO_ERRNO != $core->query(array('UPDATE "users" SET "private" = FALSE WHERE "counter" = ?',array($id)),db::FETCH_ERRNO))
                die($core->jsonResponse('error',$core->lang('ERROR')));
    break;
    case 'private':
        if(!$obj->private)
            if(db::NO_ERRNO != $core->query(array('UPDATE "users" SET "private" = TRUE WHERE "counter" = ?',array($id)),db::FETCH_ERRNO))
                die($core->jsonResponse('error',$core->lang('ERROR')));
    break;
    default:
        die($core->jsonResponse('error',$core->lang('ERROR')));
    break;
}
die($core->jsonResponse('ok','OK'));
?>
