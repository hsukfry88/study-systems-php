<?php

Class StudentModel extends Model{
	
	/**
	 * 新增学生
	 * @param [type] $data   学生数据
	 */
	public function addStudent ($data) {
		$rs = $this->findByNumber($data['number']);
		if ($rs) {
			$this->modify($rs['id'], $data);
		}else{
			$school = 3;
			$data['school'] = $school;
			$this->add($data);
		}
	}
	
	/**
	 * 通过ID查找学生
	 * @param unknown $id
	 * @return Ambigous <mixed, boolean, NULL, multitype:, unknown, string>
	 */
	public function findById ($id) {
		$school = 3;
		$where = array('id' => $id,'school' => $school);
		return $this->where($where)->find();
	}

	/**
	 * 通过学号查找学生
	 * @param  [type] $number 学号
	 * @return [type]         [description]
	 */
	public function findByNumber ($number) {
		$school = 3;
		$where = array('number' => $number,'school' => $school);
		return $this->where($where)->find();
	}
	
	/**
	 * 通过邮箱查找学生
	 * @param unknown $mail 邮箱
	 */
	public function findByMail ($mail) {
		$school = 3;
		$where = array('mail' => $mail,'school' => $school);
		return $this->where($where)->find();
	}

	/**
	 * 通过电话查找学生
	 * @param unknown $phone
	 * @return Ambigous <mixed, boolean, NULL, multitype:, unknown, string>
	 */
	public function findByPhone ($phone) {
		$school = 3;
		$where = array('phone' => $phone,'school' => $school);
		return $this->where($where)->find();
	}
	
	
	/**
	 * 通过ID更新信息
	 * @param unknown $id
	 * @param unknown $data
	 */
	public function modify($id,$data) {
		$where = array('id' => $id);
		$this->where($where)->save($data);
	}


	public function listing($school,$del = 0,$page = 1,$limit = 10) {
		$where = array('school' => $school,);
		return $this->where($where)->page($page,$limit)->select();
	}

	public function getById ($id) {
		$where = array('id' => $id);
		return $this->where($where)->find();
	}

	public function getDetail($school,$number) {
		$join_school = 'pj_school ON pj_student.school = pj_school.id';
		$join_major = 'pj_major ON pj_student.major = pj_major.id';
		$where = array('pj_student.number' => $number,'pj_student.school' => $school);
		$fields = array(
			'pj_student.id','pj_student.number','pj_student.name','pj_student.gender',
			'pj_student.phone','pj_student.qq','pj_student.mail','pj_student.head','pj_student.school','pj_student.major',
			'pj_school.name as school','pj_major.name as major'
			);
		return $this->where($where)->join($join_school)->join($join_major)->field($fields)->find();
	}

	public function getDetailById ($id) {
		$join = array(
			'pj_school ON pj_student.school = pj_school.id',
			'pj_major ON pj_student.major = pj_major.id',
			);
		$where = array('pj_student.id' => $id);
		$fields = array(
			'pj_student.id','pj_student.number','pj_student.name','pj_student.gender',
			'pj_student.phone','pj_student.qq','pj_student.head','pj_student.school','pj_student.major',
			'pj_school.name as school','pj_major.name as major'
			);
		return $this->where($where)->join($join)->field($fields)->find();
	}

	public function remove ($id) {
		$where = array('id' => $id);
		$this->where($where)->delete();
	}

	/**
	 * 列举(专业下)学生的详细信息
	 * @param string $major
	 * @return Ambigous <multitype:, mixed, boolean, NULL, string, unknown, void, multitype:multitype: >
	 */
	public function listDetail ($major = false) {
		$school = 3;
		$where = array('pj_student.school' => $school);
		if ($major) {
			$where['pj_student.major'] = $major;
		}
		$join = array(
			'pj_major ON pj_student.major = pj_major.id',
			);
		$fields = array(
			'pj_student.id',
			'pj_student.number',
			'pj_student.name',
			'pj_student.password',
			'pj_student.gender',
			'pj_student.major',
			'pj_student.phone',
			'pj_student.qq',
			'pj_student.head',
			'pj_major.name as majorname',
			);
		$users = $this->where($where)->join($join)->field($fields)->select();
// 		$data = array();
// 		foreach ($users as $value) {
// 			$data[$value['majorname']][] = $value;
// 		}
		return $users;
	}

}

?>