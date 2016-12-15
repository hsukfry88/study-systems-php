<?php


Class IndexAction extends Action{

	/**
	 * 网站首页视图
	 * @return [type] [description]
	 */
	public function index () {
		if (session('?unumber')) {
			$role = session('urole');
			redirect(U(GROUP_NAME . '/' . $role . '/index'));exit;
		}
		$this->display();
	}


	public function header () {
		$this->display();
	}


	/**
	 * 网站登录表单处理
	 * @return [type] [description]
	 */
	public function login () {
		$role = array('Student','Teacher','Teacher');
		$number = I('number','','htmlspecialchars');
		$password = I('password','','md5');
		$school = 3;//学校默认为3-代表成都东软
		$auther = I('auther',0,'htmlspecialchars');
		$db = D($role[$auther]);
		$rs = $db->findByNumber($number);
		if (!$rs) {
			$rs = $db->findByMail($number);
		}else if (!$rs) {
			$rs = $db->findByPhone($number);
		}
		if (!$rs) {
			$this->error('该用户不存在');exit;
		}
		if ($rs['password'] != $password) {
			$this->error('密码不正确');exit;
		}
		//验证密码和用户正确
		//防止老师登陆领导账户
		if ($auther == 2 && $rs['role'] != 'LEADER') {
			$this->error('用户名或密码不正确');exit;
		}
		$role = array('Student','Teacher','Leader');
		session('uid',$rs['id']);
		session('uname',$rs['name']);
		session('unumber',$number);
		session('uschool',$school);
		session('urole',$role[$auther]);
		$url = U(GROUP_NAME . '/' . $role[$auther] . '/index');
		$this->success('登陆成功',$url);
	}

	/**
	 * 用户退出注销
	 */
	public function logout () {
		session(null);
		$this->success('退出成功',U(GROUP_NAME . '/Index/index'));
	}

}

?>