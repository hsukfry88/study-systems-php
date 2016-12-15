<?php


Class SchoolAction extends CommonAction{

	/**
	 * 学校列表视图
	 * @return [type] [description]
	 */
	public function index ($page = 1,$limit = 2) {
		$province = C('PROVINCE');
		$count = D('School')->count();
		$pages = ceil($count/$limit);
		$nextpage = $page + 1;
		$prepage = $page - 1;
		if ($prepage < 1) 	$prepage = 1;
		if ($nextpage > $pages) 	$nextpage = $pages;
		$list = D('School')->schoolList($page,$limit);
		//分配到视图
		$this->assign('province',$province);
		$this->assign('count',$count);
		$this->assign('pages',$pages);
		$this->assign('page',$page);
		$this->assign('nextpage',$nextpage);
		$this->assign('prepage',$prepage);
		$this->assign('list',$list);
		$this->display();
	}

	/**
	 * 学校新增视图
	 */
	public function add () {
		$this->province = C("PROVINCE");
		$this->display();
	}

	public function addAction () {
		$province = I('province','','htmlspecialchars');
		$name = I('name','','htmlspecialchars');
		if(D('School')->addSchool($province,$name)) 
			$this->success('添加成功',U(GROUP_NAME . '/School/index'));
		else
			$this->error('添加失败，请重试');
	}

}

?>