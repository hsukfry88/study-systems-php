<?php


Class StudentAction extends CommonAction{

	/**
	 * 学生列表视图
	 * @return [type] [description]
	 */
	public function index ($page = 1,$limit = 8) {
		$studentModel = D('Student');
		$count = $studentModel->count();
		$pages = ceil($count/$limit);
		$prepage = $page - 1;
		$nextpage = $page + 1;
		$prepage < 1 && $prepage = 1;
		$nextpage > $pages && $nextpage = $pages;
		$list = D('Student')->listing(session('uschool'),0,$page,$limit);
		//分配到模板
		$this->count = $count;
		$this->pages = $pages;
		$this->page = $page;
		$this->prepage = $prepage;
		$this->nextpage = $nextpage;
		$this->list = $list;
		header("Pragma: no-cache");
		$this->display();
	}

	/**
	 * 学生导入视图
	 */
	public function add () {
		$this->display();
	}


	/**
	 * 学生导入表单处理
	 */
	public function addAction () {
		set_time_limit(0);
		$typeModel = new TypeModel();
		$majorModel = new MajorModel();
		$studentModel = new StudentModel();
		import('Classes.PHPExcel.IOFactory',APP_PATH,'.php');
		$PHPExecel = PHPExcel_IOFactory::load($_FILES['user']['tmp_name']);
		$sheet = $PHPExecel->getActiveSheet();
		$rows = $sheet->getHighestRow();
		//获取Excel有用数据
		$data = array();
		for ($i=2; $i <= $rows; $i++) {
			$tmp = array(
				'name' => $sheet->getCellByColumnAndRow(0,$i)->getValue(),
				'major' => $sheet->getCellByColumnAndRow(2,$i)->getValue(),
				'number' => $sheet->getCellByColumnAndRow(3,$i)->getValue(),
				'password' => md5($sheet->getCellByColumnAndRow(3,$i)->getValue()),
				'head' => substr(C('DEFAULT_UNDEFINED_HEAD_PATH'), 1,strlen(C('DEFAULT_UNDEFINED_HEAD_PATH'))-1),
			);
			if (is_object($tmp['major'])) {
				$richtextelement = $tmp['major'];
				$richtextelement = $richtextelement->getRichTextElements()[0]->getText();
				$tmp['major'] = $richtextelement;
			}
			//数据中Major的确立
			if ($rs = $majorModel->search($tmp['major'])){
				$tmp['major'] = $rs['id'];
			}else{
				$type = $typeModel->search(C('DEFAULT_PRODUCT_TYPE'))['id'];
				$tmp['major'] = $majorModel->addMajor($tmp['major'], $type);
			}
			//添加学生
			$studentModel->addStudent($tmp);
		}
		$this->success('导入成功',U(GROUP_NAME . '/Student/index'));
	}

	public function remove ($id) {
		$id = htmlspecialchars($id);
		D('Student')->remove($id);
		$this->redirect(GROUP_NAME . '/Student/index');
	}
}

?>