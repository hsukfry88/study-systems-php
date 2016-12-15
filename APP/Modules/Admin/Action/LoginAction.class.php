<?php


Class LoginAction extends Action{

	/**
	 * 后台登录视图
	 * @return [type] [description]
	 */
	public function index () {
		$this->display();
	}

	/**
	 * 后台登录表单处理
	 * @return [type] [description]
	 */
	public function login () {
		$user = I('username','','htmlspecialchars');
		$password = I('pwd','','htmlspecialchars');
		if( $user == C("LOGIN_USER") && md5($password) == C('LOGIN_PASSWORD') ) {
			session('uname',$user);
			session('logintime',C('LOGIN_TIME'));
			session('loginip',C('LOGIN_IP'));
			session('uschool',3);
			//更新登录时间和IP
			C('LOGIN_TIME','2090');
			C('LOGIN_IP',get_client_ip());
			$this->success('登陆成功',__GROUP__);
		}
		else
			$this->error('用户名或密码错误');
	}

}

?>