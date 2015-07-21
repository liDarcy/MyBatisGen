<?php
include_once 'config.php';


$action = $_GET['action'];
if($action == 'send')
{
	$id = (int)$_POST['id'];
	$mid = (int)$_POST['moodid'];
	if(!$mid || !$id)
	{
		echo "此链接不存在";exit;
	}
	
	$havemood = chk_mood($id);
	if($havemood == 1)
	{
		echo "您已经发表过心情了，保持平常心有益身心健康！";exit;
	}
	$field = 'mood'.$mid;
	$query = $this->_conn
}
else
{
	
}