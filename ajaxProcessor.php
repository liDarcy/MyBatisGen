<?php 
	require_once 'globals/AjaxProcessorBasic.php';
	require_once 'globals/include.php';

	class AjaxProcessor extends AjaxProcessorBasic
	{
		protected $_conn;
		public function __construct()
		{
			$this->_conn = Connection::getInstance();
		}
		
		public function actionUserAdd()
		{
			$addPost = $this->getPost('add', null);
			if($addPost){
				$result = false;
				$errors = userAddVerify($addPost);
				if($errors === true){
					$result = $this->_conn->execute('
						INSERT INTO users SET name=?, birthday=?, gender=?, department=?, class=?
					', array(
						$addPost['name'], $addPost['birthday'], $addPost['gender'], $addPost['department'], $addPost['class'], 
					));
				}
				
				$this->_returnAjax(array(
					'result' => $result,
					'errors' => $errors,
					'addPost' => array_merge($addPost, array(
						'id' => $this->_conn->getLastInsert()
					))
				));
			}
		}
		
		public function actionUserEdit()
		{
			$id = $this->getParam('id', null);
			$modifyPost = $this->getPost('modify', null);
			if($id && $modifyPost){
				$result = false;
				$errors = userAddVerify($modifyPost);
				if($errors === true){
					$result = $this->_conn->execute('
						UPDATE users SET name=?, birthday=?, gender=?, department=?, class=? WHERE id=?
					', array(
						$modifyPost['name'], $modifyPost['birthday'], $modifyPost['gender'], $modifyPost['department'], $modifyPost['class'], $id
					));
				}
				
				$this->_returnAjax(array(
					'result' => $result,
					'errors' => $errors,
					'modifyPost' => array_merge($modifyPost, array(
						'id' => $id
					))
				));
			}
		}
		
		
	}
	
	$ajaxProcessor = new AjaxProcessor();
	$ajaxProcessor->run();