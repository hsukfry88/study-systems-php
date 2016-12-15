<?php


Class CourseAction extends Action{

	public function get () {
		$condition = $this->parseCondition();
		$data = $this->executeRequest($condition);
		import('Classes.XMLCourse',APP_PATH);
		$xmlCourse = new XMLCourse();
		$xmlCourse->add($data);
		$xmlCourse->saveHTML();
	}

	private function parseCondition () {
		$condition = array(
			'target' => null,
			'starttime' => null,
			'endtime' => null,
			'teacher' => null,
			);
		$condition['target'] = I('target',null,'htmlspecialchars');
		$condition['starttime'] = I('starttime',null,'htmlspecialchars');
		$condition['endtime'] = I('endtime',null,'htmlspecialchars');
		$condition['teacher'] = I('teacher',null,'htmlspecialchars');
		return $condition;
	}

	private function executeRequest ($condition) {
		if (is_null($condition['target'])) 
			$targetWhere = "pj_course.id != 0";
		else
			$targetWhere = "pj_course.id in (" . $condition['target'] . ")";
		if (is_null($condition['starttime'])) 
			$starttimeWhere = "pj_course.buildTime != -1";
		else
			$starttimeWhere = "pj_course.buildTime > " . $condition['starttime'];
		if (is_null($condition['endtime'])) 
			$endtimeWhere = "pj_course.submitTime != -1";
		else
			$endtimeWhere = "pj_course.submitTime > " . $condition['endtime'];
		if (is_null($condition['teacher'])) 
			$teacherWhere = "pj_course.teacher != 0";
		else
			$teacherWhere = "pj_course.teacher in (" . $condition['teacher'] . ")";
		$where = array($targetWhere,$starttimeWhere,$endtimeWhere,$teacherWhere);
		return M('Course')->where($where)->select();
	}

}

?>