<?php

/**
 * 学校模型
 */
Class SchoolModel extends Model{
	
	/**
	 * 新增学校
	 * @param [String] $province [省份,函数内检查省份合法性]
	 * @param [String] $name     [学校名]
	 */
	public function addSchool ($province,$name) {
		//如果存在则不允许加入
		if ($this->existSchool($province,$name))
			return false;

		$arr = C('PROVINCE');
		$data = array('name'=>$name,'province'=>$province);
		if (in_array($province, $arr)) 
			return $this->add($data);
		else
			return false;
	}

	/**
	 * 学校列表
	 * @param  integer $page  [页数]
	 * @param  integer $limit [每页显示数目]
	 * @return [type]         [返回结果集]
	 */
	public function schoolList ($page = 1 , $limit = 10) {
		return $this->page($page,$limit)->select();
	}
	

	/**
	 * 学校是否存在
	 * @param  [String] $province [省份]
	 * @param  [String] $name     [学校名称]
	 * @return [type]           [description]
	 */
	private function existSchool ($province,$name) {
		return $this->where("name = '%s' AND province = '%s'",$name,$province)->find();
	}


	public function getName ($id) {
		return $this->where("id = %d",$id)->getField('name');
	}


}

?>