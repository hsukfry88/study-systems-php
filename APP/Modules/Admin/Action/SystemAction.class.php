<?php

Class SystemAction extends CommonAction{

	/**
	 * 系统设置主视图，默认为管理员账号
	 * @return [type] [description]
	 */
	public function index () {
		$this->display();
	}

	/**
	 * 管理员密码视图
	 * @return [type] [description]
	 */
	public function password () {
		$this->display();
	}

	/**
	 * 系统设置视图
	 * @return [type] [description]
	 */
	public function option () {
		$this->display();
	}

	/**
	 * 管理员账号设置表单提交
	 * @return [type] [description]
	 */
	public function adminAction () {
		$username = I('name','admin','htmlspecialchars');
		$data = include(CONF_PATH.'admin.php');
		$data['LOGIN_USER'] = $username;
		F('admin',$data,CONF_PATH);
		session(null);
		$msg = '管理员账号已被修改为'.$username.',请重新登录!';
		redirect(__GROUP__);
	}

	/**
	 * 管理员密码设置表单提交
	 * @return [type] [description]
	 */
	public function passwordAction () {
		$password = I('password','admin','htmlspecialchars');
		$data = include(CONF_PATH.'admin.php');
		$data['LOGIN_PASSWORD'] = md5($password);
		F('admin',$data,CONF_PATH);
		session(null);
		$msg = '密码已修改,请重新登录!';
		redirect(U(GROUP_NAME . '/Login/index'));
	}

}

?>