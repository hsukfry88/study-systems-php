<?php
Class TypeModel extends Model{
	
	protected $tableName = 'producttype';

	/**
	 * 新增类型
	 * @param [type] $name   [description]
	 * @param [type] $remark [description]
	 */
	public function addType ($name,$remark) {
		if ($this->search($name)) {
			return false;
		}
		$data = array('name' => $name,'remark' => $remark);
		return $this->add($data);
	}

	public function listing () {
		return $this->select();
	}

	public function search ($name) {
		$where = array('name' => $name);
		return $this->where($where)->find();
	}

	public function remove ($id) {
		$where = array('id' => $id);
		$this->where($where)->delete();
	}
}

?>