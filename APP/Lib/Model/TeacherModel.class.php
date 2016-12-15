<?php

Class TeacherModel extends Model{
	
	/**
	 * 新增教师
	 * @param unknown $data
	 */
	public function addTeacher ($data) {
		foreach ($data as $value) {
			if ($rs = $this->findByNumber($value['number'])) {
				$this->modify($rs['id'],$value);
			}else{
				$this->add($value);
			}
		}
	}

	/**
	 * 通过ID查找教师
	 * @param unknown $id
	 * @return Ambigous <mixed, boolean, NULL, multitype:, unknown, string>
	 */
	public function findById ($id) {
		$where = array('id' => $id);
		return $this->where($where)->find();
	}
	
	public function findByNumber ($number) {
		$school = 3;
		$where = array('school' => $school,'number' => $number);
		return $this->where($where)->find();
	}
	
	public function findByMail ($mail) {
		$school = 3;
		$where = array('mail' => $mail,'school' => $school);
		return $this->where($where)->find();
	}
	
	public function findByPhone ($phone) {
		$school = 3;
		$where = array('phone' => $phone,'school' => $school);
		return $this->where($where)->find();
	}
	
	/**
	 * 查找教师
	 * @param  [数字] $school [学校ID]
	 * @param  [字符串] $number [教师编号]
	 * @return [type]         [description]
	 */
	public function search ($school,$number) {
		$where = array('number' => $number,'school' => $school);
		return $this->where($where)->find();
	}

	/**
	 * 删除教师
	 * @param  [数字] $school [学校ID]
	 * @param  [字符串] $number [教师编号]
	 * @return [type]         [description]
	 */
	public function remove ($id) {
		$where = array('id'=>$id);
		$this->where($where)->delete();
	}

	/**
	 * 修改教师信息
	 * @param  [数字] $school [学校ID]
	 * @param  [字符串] $number [教师编号]
	 * @param  [一维数组] $data   [教师信息]
	 * @return [type]         [description]
	 */
	public function modify($id,$data) {
		$school = 3;
		$where = array('id' => $id,'school' => $school);
		$this->where($where)->save($data);
	}

	/**
	 * 按页数教师列表
	 * @param  integer $page  页数
	 * @param  integer $limit 每页显示个数
	 * @return [type]         [description]
	 */
	public function listing($page = 1,$limit = 10) {
		$fields = array('id','number','name','role','qq','email');
		return $this->field($fields)->page($page,$limit)->select();
	}

	public function getDetailById ($id) {
		$where = array('id'=>$id);
		return $this->where($where)->find();
	}
	

}

?>