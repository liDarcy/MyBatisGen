<?php
include_once 'config.php';


$action = $_GET['action'];
if($action == 'send')
{
	$id = (int)$_POST['id'];
	$mid = (int)$_POST['moodid'];
	if(!$mid || !$id)
	{
		echo "�����Ӳ�����";exit;
	}
	
	$havemood = chk_mood($id);
	if($havemood == 1)
	{
		echo "���Ѿ�����������ˣ�����ƽ�����������Ľ�����";exit;
	}
	$field = 'mood'.$mid;
	$query = $this->_conn
}
else
{
	
}