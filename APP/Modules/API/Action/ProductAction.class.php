<?php

/**
* 
*/
Class ProductAction extends Action{

	public function get () {
		$condition = $this->parseCondition($condition);
		$data = $this->executeRequest($condition);
		import('Classes.XMLProduct',APP_PATH);
		$xmlProduct = new XMLProduct();
		$xmlProduct->add($data);
		$xmlProduct->saveHTML();
		
	}

	private function parseCondition () {
		$condition = array(
			'exhibition' => null,
			'major' => null,
			'type' => null,
			'teacher' => null,
			'author' => null,
			'starttime' => null,
			'endtime' => null,
			);
		$condition['exhibition'] = I('exhibition',null,'htmlspecialchars');
		$condition['major'] = I('major',null,'htmlspecialchars');
		$condition['type'] = I('type',null,'htmlspecialchars');
		$condition['teacher'] = I('teacher',null,'htmlspecialchars');
		$condition['author'] = I('author',null,'htmlspecialchars');
		$condition['starttime'] = I('starttime',null,'htmlspecialchars');
		$condition['endtime'] = I('endtime',null,'htmlspecialchars');
		return $condition;
	}

	private function executeRequest ($condition) {
		//p($condition);die;
		if (is_null($condition['major'])) {
			$majorWhere = "pj_product.major != 0";
		}else
			$majorWhere = "pj_product.major in (" . $condition['major'] . ")";
		if (is_null($condition['type'])) {
			$typeWhere = "pj_product.type != 0";
		}else
			$typeWhere = "pj_product.type in (" . $condition['type'] . ")"; 
		if (is_null($condition['teacher'])) {
			$teacherWhere = "pj_product.teacher != 0";
		}else
			$teacherWhere = "pj_product.teacher in (" . $condition['teacher'] . ")";
		if (is_null($condition['starttime'])) {
			$starttimeWhere = "pj_product.subtime != -1";
		}else
			$starttimeWhere = "pj_product.subtime > " . $condition['starttime'];
		if (is_null($condition['endtime'])) {
			$endtimeWhere = "pj_product.uptime != -1"; 
		}else
			$endtimeWhere = "pj_product.uptime > " .$condition['endtime'];
		$where = array($majorWhere,$typeWhere,$teacherWhere,$starttimeWhere,$endtimeWhere);
		$model = M('Product');
		$data = $model->where($where)->select();
		foreach ($data as $key => $value) {
			$exhibitionModel = D('Exhibitionp');
			$rs = $exhibitionModel->where("productID = %d",$value['id'])->find();
			if (is_null($rs)) {
				unset($data[$key]);
			}
			if (!is_null($condition['exhibition']) && $rs['exhibitionID'] != $condition['exhibition']) {
				unset($data[$key]);
			}
			$author = json_decode($value['author']);
			if (!is_null($condition['author']) && !in_array($condition['author'], $author)) {
				unset($data[$key]);
			}
		}
		return $data;
	}

}




?>