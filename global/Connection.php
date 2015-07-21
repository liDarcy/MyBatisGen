<?php 
class Connection
{
	protected $_host = 'localhost';
	protected $_dbname = 'user';
	protected $_user = 'root';
	protected $_pass = '123';
	
	private static $_conn = null;
	protected $_pdo_r = null;
	protected $_pdo_w = null;
	
	/**
	 * @return Connection
	 */
	public static function getInstance()
	{
		if(empty(self::$_link)){
			self::$_conn = new Connection();
		}
		
		return self::$_conn;
	}
	
	private function __construct()
	{
		$dns = "mysql:host=".$this->_host.";dbname=".$this->_dbname;
		
		$this->_pdo_r = new PDO($dns, $this->_user, $this->_pass);
		$this->_pdo_r->prepare("set names 'utf8'")->execute();
		
		$this->_pdo_w = new PDO($dns, $this->_user, $this->_pass);
		$this->_pdo_w->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->_pdo_w->prepare("set names 'utf8'")->execute();
	}
	
	public function query($sql, $param=array())
	{
		$result = array();
		$stmt = $this->_pdo_r->prepare($sql);
		$stmt->execute($param);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		foreach ($stmt as $k => $v)
		{
			$result[$k] = $v;
		}
		return $result;
	}
	
	public function execute($sql, $param=array(), $lastInsertId = false)
	{
		$stmt = $this->_pdo_w->prepare($sql);
		$result = $stmt -> execute($param);
		if($lastInsertId && $result){
			return $this->_pdo_w->lastInsertId();
		}
		return $result;
	}
	
	public function getLastInsert(){
		if($this->_pdo_w){
			return	$this->_pdo_w->lastInsertId();
		}else{
			return false;
		}
	}
}