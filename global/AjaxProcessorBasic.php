<?php 
	class AjaxProcessorBasic
	{
		public function run()
		{
			$action = strtolower('action' . $this->getParam('action', null));
			$methods = get_class_methods(get_class($this));
			foreach($methods as $method){
				if(strtolower($method) == $action){
					return $this->$action();
				}
			}
			
			return false;
		}
		
		protected function _returnAjax($msg = '', $byJson = true)
		{
			if($byJson){
				$msg = json_encode($msg);
			}
			echo $msg;
			$this->_end();
		}
	    
		protected function _end($status=0, $exit=true)
		{
			if($exit)
				exit($status);
		}
		
		public function getParam($name, $defaultValue=null)
		{
			return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $defaultValue);
		}
		
		public function getPost($name,$defaultValue=null)
		{
			return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
		}
		
		public function getSiteRoot()
		{
			return dirname(dirname(dirname(__FILE__)));
		}
	}