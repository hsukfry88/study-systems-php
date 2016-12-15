<?php

Class MajorAction extends CommonAction{

	/**
	 * 专业列表视图
	 * @return [type] [description]
	 */
	public function index () {
		$this->list = D('Major')->listing(3);
		$this->display();
	}

	/**
	 * 专业新增视图
	 */
	public function add () {
		$this->type = D('Type')->listing();
		$this->display();
	}

	/**
	 * 专业新增处理表单
	 */
	public function addAction () {
		$school = I('school',3,'htmlspecialchars');
		$name = I('name','','htmlspecialchars');
		$type = I('type',0,'htmlspecialchars');
		if (D('Major')->addMajor($school,$name,$type)) {
			$this->success('添加专业成功',U(GROUP_NAME . '/Major/index'));
		}else{
			$this->error('添加失败');
		}
	}

	public function remove ($id) {
		$id = htmlspecialchars($id);
		D('Major')->remove($id);
		$this->redirect(GROUP_NAME . '/Major/index');
	}
}

?>