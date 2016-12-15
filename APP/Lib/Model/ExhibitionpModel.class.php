<?php

Class ExhibitionpModel extends Model{
	
	protected $tableName = 'exhibition_product';

	public function getProductsByExhibition ($exhibition) {
		$where = array('exhibitionID' => $exhibition);
		return $this->where($where)->select();
	}
	
	public function getExhibitionsByProduct ($product) {
		$where = array('productID' => $product);
		return $this->where($where)->select();
	}
	
	public function append ($product,$exhibition) {
		$data = array('productID'=>$product,'exhibitionID'=>$exhibition);
		return $this->add($data);
	}

	public function verify ($product) {
		$where = array('productID'=>$product);
		return $this->where($where)->setField('verify',1);
	}

	public function remove ($product,$exhibition) {
		$where = array('productID'=>$product,'exhibitionID'=>$exhibition);
		return $this->where($where)->delete();
	}
	
	
	//查找老师所创建的所有展厅信息
	public function allListexhibition($id){
		$where=array('sponsor'=>$id);
		return $this->where($where)->select();
	}

// 	public function getProductionByExhibition ($exhibition) {
// 		$productModel = D('Product');
// 		$where = array('exhibitionID' => $exhibition);
// 		$data = $this->where($where)->select();
// 		foreach ($data as $key => $value) {
// 			$product = $productModel->getDetailById($value['productID']);
// 			$author = json_decode($product['author']);
// 			foreach ($author as $k => $v) {
// 				$author[$k] = D('Student')->getDetailById($v);
// 			}
// 			$product['author'] = $author;
// 			$data[$key]['product'] = $product;
// 		}
// 		return $data;
// 	}
}

?>