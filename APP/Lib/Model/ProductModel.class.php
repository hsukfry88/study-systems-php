<?php

Class ProductModel extends Model{
	
	private $join = array(
		'pj_major ON pj_product.major = pj_major.id',
		'pj_producttype ON pj_product.type = pj_producttype.id',
		'pj_teacher ON pj_product.teacher = pj_teacher.id',
		'pj_course ON pj_product.course = pj_course.id',
	);
	
	private $column = array(
		'pj_product.id',
		'pj_product.name',
		'pj_product.type as typeID',
		'pj_product.course as courseID',
		'pj_product.major as majorID',
		'pj_product.author',
		'pj_product.joiner',
		'pj_product.teacher as teacherID',
		'pj_product.intro',
		'pj_product.thumb',
		'pj_product.effectPic',
		'pj_product.media',
		'pj_product.others',
		'pj_product.subtime',
		'pj_product.upTime',
		'pj_product.grade',
		'pj_product.praise',
		'pj_product.comment',
		'pj_product.verify',
		'pj_major.name as major',
		'pj_producttype.name as type',
		'pj_teacher.name as teacher',
		'pj_course.name as course',
	);
	
	
	public function findById ($id) {
		$where = array('pj_product.id' => $id);
		return $this->where($where)->find();
	}
	
	
	public function addProduct ($data) {
		return $this->add($data);
	}

	public function getDetailById ($id) {
		$where = array('id' => $id);
		return $this->where($where)->find();
	}
	
	/**
	 * 列举出学生参与的所有（审核通过/未通过）作品
	 * @param unknown $student
	 * @param string $isVerify
	 */
	public function listAllJoinedWithStudent ($student, $isVerify = null) {
		$where = array();
		if ($isVerify === true) {
			$where['pj_product.verify'] = 1;
		}else if ($isVerify === false){
			$where['pj_product.verify'] = 0;
		}
		$data = $this->where($where)->join($this->join)->field($this->column)->select();
		if ($data === null)		return null;
		$product = array();
		//判断是否满足学号
		foreach ($data as $value) {
			if (array_search($student, explode("|", $value['author'])) === false)	continue;
			$product[] = $value;
		}
		$product = $this->getExhibitionByProduct($product);
		return $product;
	}
	
	/**
	 * 列举与教师相关的所有(课程下)作品
	 * @param unknown $teacher
	 * @param string $verify
	 */
	public function listAllWithTeacherAndMajor ($teacher, $course = null) {
		$where = array();
		$where['pj_product.teacher'] = $teacher;
		if ($course !== null) {
			$where['pj_product.course'] = $course;
		}
		$data = $this->where($where)->join($this->join)->field($this->column)->select();
		return $data;
	}
	
	
	public function listAllByExhibition ($exhibition) {
		$exhibitionp = new ExhibitionpModel();
	}
	
	
	
	public function listallByStudent ($school,$student) {
		$where = array('pj_product.school' => $school);
		$join = array(
			'pj_major ON pj_product.major = pj_major.id',
			'pj_producttype ON pj_product.type = pj_producttype.id',
			'pj_teacher ON pj_product.teacher = pj_teacher.id',
			'pj_course ON pj_product.course = pj_course.id',
			);
		$fields = array(
			'pj_product.id',
			'pj_product.name',
			'pj_product.type as typeID',
			'pj_product.course as courseID',
			'pj_product.major as majorID',
			'pj_product.author',
			'pj_product.joiner',
			'pj_product.teacher as teacherID',
			'pj_product.intro',
			'pj_product.thumb',
			'pj_product.effectPic',
			'pj_product.media',
			'pj_product.others',
			'pj_product.upTime',
			'pj_product.grade',
			'pj_product.praise',
			'pj_product.verify',
			'pj_major.name as major',
			'pj_producttype.name as type',
			'pj_teacher.name as teacher',
			'pj_course.name as course',
			);
		$products = $this->where($where)->join($join)->field($fields)->select();
		$data = array();
		foreach ($products as $value) {
			$tmp1 = json_decode($value['author']);
			$tmp2 = json_decode($value['joiner']);
			$author = array_merge($tmp1,$tmp2);
			$author = array_unique($author);
			if (in_array($student, $author)) {
				$data[] = $value;
			}
		}
		return $data;
	}

	public function listallByTeacher ($school,$teacher) {
		$where = array('pj_product.school' => $school,'pj_product.teacher' => $teacher);
		$join = array(
			'pj_major ON pj_product.major = pj_major.id',
			'pj_producttype ON pj_product.type = pj_producttype.id',
			'pj_teacher ON pj_product.teacher = pj_teacher.id',
			'pj_course ON pj_product.course = pj_course.id',
			);
		$fields = array(
			'pj_product.id',
			'pj_product.name',
			'pj_product.type as typeID',
			'pj_product.course as courseID',
			'pj_product.major as majorID',
			'pj_product.author',
			'pj_product.joiner',
			'pj_product.teacher as teacherID',
			'pj_product.intro',
			'pj_product.thumb',
			'pj_product.effectPic',
			'pj_product.media',
			'pj_product.others',
			'pj_product.upTime',
			'pj_product.grade',
			'pj_product.praise',
			'pj_product.verify',
			'pj_major.name as major',
			'pj_producttype.name as type',
			'pj_teacher.name as teacher',
			'pj_course.name as course',
			);
		$products = $this->join($join)->where($where)->field($fields)->select();
		foreach ($products as $key => $value) {
			$author = json_decode($value['author']);
			$joiner = json_decode($value['joiner']);
			foreach ($author as $k => $v) {
				$v = D('Student')->getById($v);
				$v['major'] = D('Major')->getName($v['major']);
				$author[$k] = $v;
			}
			foreach ($joiner as $k => $v) {
				$v = D('Student')->getById($v);
				$v['major'] = D('Major')->getName($v['major']);
				$joiner[$k] = $v;
			}
			$products[$key]['author'] = $author;
			$products[$key]['joiner'] = $joiner;

			$products[$key]['thumb'] = __ROOT__ . trim($value['thumb'],'.');

			$effectPic = json_decode($value['effectPic']);
			foreach ($effectPic as $key => $value) {
				$effectPic[$key] = __ROOT__ . trim($value,'.');
			}
			$products[$key]['effectPic'] = $effectPic;
		}
		return $products;
	}

	private function getExhibitionByProduct ($product) {
		$exhibition = new ExhibitionModel();
		foreach ($product as $key => $value) {
			$value['exhibitions'] = $exhibition->getExhibitionsByProduct($value['id']);
			$product[$key] = $value;
		}
		return $product;
	}
	
	
	//插入分数和教师 评论 字段数据
	public function grade ($product,$data) {
		$where = array('id' => $product);
		$this->where($where)->setField('verify',1);
		$this->where($where)->setField('grade',$data['grade']);
		return$this->where($where)->setField('comment',$data['comment']);
		 
	}
	
	//插入分数和教师 评论 字段数据
	public function agreeVerify ($product) {
		//$data = array('productID'=>$product,'exhibitionID'=>$exhibition);
		$where = array('id' => $product);
		return $this->where($where)->setField('exState',1);
		
		
		//$this->where($where)->setField('exState',1);
	}
	
		
	//删除作品信息
	public function deleteProductInfo($product) {
	
		$this->where($where)->delete();
	}
	
	//读取开设展厅信息
	public function readExhibitionList(){
		$Data = new ExhibitionModel();
		$list=$Data->select();
		return $list;
	}

	
}

?>