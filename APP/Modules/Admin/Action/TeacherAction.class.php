<?php


Class TeacherAction extends CommonAction{

	/**
	 * 学生列表视图
	 * @return [type] [description]
	 */
	public function index ($page = 1,$limit = 8) {
		$teacherModel = D('Teacher');
		$count = $teacherModel->count();
		$pages = ceil($count/$limit);
		$prepage = $page - 1;
		$nextpage = $page + 1;
		$prepage < 1 && $prepage = 1;
		$nextpage > $pages && $nextpage = $pages;
		$list = $teacherModel->listing($page,$limit);
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
		import('Classes.PHPExcel.IOFactory',APP_PATH,'.php');
		$PHPExecel = PHPExcel_IOFactory::load($_FILES['user']['tmp_name']);
		$sheet = $PHPExecel->getActiveSheet();
		$rows = $sheet->getHighestRow();
		$cols = $sheet->getHighestColumn();
		$cols = PHPExcel_Cell::columnIndexFromString($cols);
		$data = array();
		$role = array(
			'领导' => 'LEADER',
			'教师' => 'TEACHER',
			);
		$sex = array(
			'男' => "MALE",
			"女" => "FEMALE",
		);
		$school = 3;
		for ($i=2; $i <= $rows; $i++) { 
			$data[] = array(
				'number' => $sheet->getCellByColumnAndRow(0,$i)->getValue(),
				'name' => $sheet->getCellByColumnAndRow(1,$i)->getValue(),
				'role' => $role[$sheet->getCellByColumnAndRow(4,$i)->getValue()],
				'password' => md5($sheet->getCellByColumnAndRow(0,$i)->getValue()),
				'sex' => $sex[$sheet->getCellByColumnAndRow(2,$i)->getValue()],
				'school' => $school,
				);
			if ($data[$i-2]['sex'] == 'MALE') {
				$data[$i-2]['head'] = substr(C('DEFAULT_MAN_HEAD_PATH'),1);
			}else {
				$data[$i-2]['head'] = substr(C('DEFAULT_WOMAN_HEAD_PATH'),1);
			}
		}
		D('Teacher')->addTeacher($data);
		$this->success('导入成功',U(GROUP_NAME . '/Teacher/index'));
	}


	public function remove ($id) {
		$id = htmlspecialchars($id);
		D('Teacher')->remove($id);
		$this->redirect(GROUP_NAME . '/Teacher/index');
	}
}

?>