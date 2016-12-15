<?php


Class IndexAction extends CommonAction{

	/**
	 * 后台首页视图
	 * @return [type] [description]
	 */
	public function index () {
		$this->display();
	}

	/**
	 * 后台欢迎页视图
	 * @return [type] [description]
	 */
	public function welcome () {
		$this->os = $this->getSystem();
		$this->environment = $this->getEnvironment();
		$this->executeTime = $this->getExecuteTime();
		$this->uploadSize = $this->getUploadSize();
		$this->serviceTime = $this->getServiceTime();
		$this->host = $this->getHost();
		$this->display();
	}

	/**
	 * 获取操作系统
	 * @return [type] [description]
	 */
	private function getSystem () {
		return PHP_OS;
	}

	/**
	 * 获取运行环境
	 * @return [type] [description]
	 */
	private function getEnvironment () {
		return $_SERVER["SERVER_SOFTWARE"];
	}
	
	/**
	 * 获取上传文件限制
	 * @return [type] [description]
	 */
	private function getUploadSize () {
		return ini_get('upload_max_filesize');
	}

	/**
	 * 获得执行时间
	 * @return [type] [description]
	 */
	private function getExecuteTime () {
		return ini_get('max_execution_time');
	}

	/**
	 * 获取服务器时间
	 * @return [type] [description]
	 */
	private function getServiceTime () {
		return date("Y年n月j日 H:i:s");
	}

	/**
	 * 获取域名信息
	 * @return [type] [description]
	 */
	private function getHost () {
		return $_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]';
	}

}

?>