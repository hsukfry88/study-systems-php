<?php

Class TypeAction extends CommonAction{

	/**
	 * 类型列表视图
	 * @return [type] [description]
	 */
	public function index () {
		$this->list = D('Type')->listing();
		$this->display();
	}

	/**
	 * 类型添加视图
	 */
	public function add () {
		$this->display();
	}

	public function addAction () {
		$name = I('name','','htmlspecialchars');
		$remark = I('mark','','htmlspecialchars');
		if (!D('Type')->addType($name,$remark)) {
			$this->error('添加失败');
		}else{
			$this->success('添加成功',U(GROUP_NAME . '/Type/index'));
		}
	}

	public function remove ($id) {
		$id = htmlspecialchars($id);
		D('Type')->remove($id);
		$this->redirect(GROUP_NAME . '/Type/index');
	}

}

?>