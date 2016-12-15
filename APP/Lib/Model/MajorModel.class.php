<?php

Class MajorModel extends Model{
	
	/**
	 * 添加专业
	 * @param [type] $school [description]
	 * @param [type] $name   [description]
	 */
	public function addMajor ($name,$type) {
		$school = 3;
		if ($this->search($name)) {
			return false;
		}
		return $this->add(array('school'=>$school,'name'=>$name,'type'=>$type));
	}

	/**
	 * 查找专业
	 * @param  [type] $school [description]
	 * @param  [type] $name   [description]
	 * @return [type]         [description]
	 */
	public function search ($name) {
		$school = 3;
		$where = array('school' => $school,'name' => $name);
		return $this->where($where)->find();
	}

	public function listing ($school,$del = 0) {
		$where = array('school' => $school,'isDel' => $del);
		return $this->where($where)->select();
	}

	public function getIdByName ($school,$name) {
		$rs = $this->search($school,$name);
		return $rs['id'];
	}

	public function remove ($id) {
		$where = array('id' => $id);
		$this->where($where)->delete();
	}

	public function getName ($id) {
		$where = array('id' => $id);
		return $this->where($where)->getField('name');
	}
}

?>