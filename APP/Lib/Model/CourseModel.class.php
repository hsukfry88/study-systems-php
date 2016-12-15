<?php

Class CourseModel extends Model{
	
	/**
	 * 添加课程
	 * @param [type] $data   课程信息数组
	 */
	public function addCourse ($data) {
		//p($data);die;
		//var_dump($this->search($data['name']));exit;
		if ($this->search($data['name'])) {
			return false;
		}
		return $this->add($data);
	}

	/**
	 * 通过ID得到课程信息
	 * @param unknown $id
	 * @return Ambigous <mixed, boolean, NULL, multitype:, unknown, string>
	 */
	public function findById ($id) {
		$where = array('id' => $id);
		return $this->where($where)->find();
	}
	
	/**
	 * 通过ID得到课程详细信息
	 * @param unknown $id
	 */
	public function findDetailById ($id) {
		$where = array('pj_course.id' => $id);
		$join = array(
				'pj_teacher ON pj_course.teacher = pj_teacher.id',
				'pj_producttype on pj_course.type = pj_producttype.id',
		);
		$fields = array(
				'pj_course.id',
				'pj_course.name',
				'pj_course.type',
				'pj_course.buildTime',
				'pj_course.submitTime',
				'pj_course.brief',
				'pj_course.teacher as teacher',
				'pj_course.school',
				'pj_teacher.name as teachername',
				'pj_producttype.name as typename',
		);
		return $this->join($join)->where($where)->field($fields)->find();
	}
	
	/**
	 * 通过课程名查找课程
	 * @param unknown $name
	 * @param string $major
	 * @return Ambigous <mixed, boolean, NULL, multitype:, unknown, string>
	 */
	public function search ($name,$major = null) {
		$school = 3;
		$where = array('school'=> $school,'name' => $name);
		if ($major)		$where['major'] = $major;
		return $this->where($where)->find();
	}

	/**
	 * 取出所有课程
	 * @return Ambigous <mixed, boolean, NULL, string, unknown, multitype:, void, multitype:multitype: >
	 */
	public function listall() {
		$school = 3;
		$where = array('pj_course.school' => $school);
		$join = array(
				'pj_teacher ON pj_course.teacher = pj_teacher.id',
		);
		$fields = array(
				'pj_course.id',
				'pj_course.name',
				'pj_course.type',
				'pj_course.teacher as teacher',
				'pj_course.school as school',
				'pj_teacher.name as teachername',
		);
		$data = $this->join($join)->where($where)->field($fields)->select();
		for ($i=0; $i < count($data); $i++) {
			$where = array('id' => $data[$i]['type']);
			$data[$i]['typename'] = D('Type')->where($where)->getField('name');
		}
		return $data;
	}
	
	
	
	/**
	 * 列出专业下所有课程
	 * @param string $major
	 * @return Ambigous <mixed, NULL, multitype:Ambigous <unknown, string> unknown , unknown, multitype:>
	 */
	public function listallByMajor ($major = false) {
		$school = 3;
		$where = array('pj_course.school' => $school);
		if ($major) {
		$join = array(
			'pj_major ON pj_course.major = pj_major.id',
			'pj_teacher ON pj_course.teacher = pj_teacher.id',
			);
		$fields = array(
			'pj_course.id',
			'pj_course.name',
			'pj_course.major as major',
			'pj_course.teacher as teacher',
			'pj_course.school as school',
			'pj_major.name as majorname',
			'pj_major.type as type',
			'pj_teacher.name as teachername',
			);
		$data = $this->join($join)->where($where)->field($fields)->select();
		}else {
			$data = $this->where($where)->select();
		}
		for ($i=0; $i < count($data); $i++) {
			$where = array('id' => $data[$i]['type']);
			$data[$i]['typename'] = D('Type')->where($where)->getField('name');
		}
		return $data;
	}

}

?>