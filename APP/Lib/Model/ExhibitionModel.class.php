<?php

Class ExhibitionModel extends Model{
	
	//读取展厅内作品信息
	public function readExhibitionProductList($id){
		$Data = new ExhibitionpModel();
		$where = array('exhibitionID' => $id);
		$list=$Data->where($where)->select();
		return $list;
	}
	
	
	public function addExhibition ($data) {
		return $this->add($data);
	}

	public function listAllByLeader ($leader) {
		$where = array('sponsor' => $leader);
		return $this->where($where)->select();
	}
	

	public function findByID ($id) {
		$where = array('id' => $id);
		return $this->where($where)->find();
	}
	
	public function getProductsByExhibition ($exhibition, $mode = null) {
		$data = array();
		$exhibitionp = new ExhibitionpModel();
		$productModel = new ProductModel();
		$products = $exhibitionp->getProductsByExhibition($exhibition);
		foreach ($products as $key => $value) {
			$rs = $productModel->findById($value['productID']);
			if ($mode === null) {
				$data[] = $rs;
			}else if($mode === true) {
				if ($rs['verify'] == 1)
					$data[] = $rs;
			}else if ($mode === false) {
				if ($rs['verify'] == 0)
					$data[] = $rs;
			}
		}
		return $data;
	}
	
	public function getExhibitionsByProduct ($product) {
		$data = array();
		$exhibitionp = new ExhibitionpModel();
		$exhibitions = $exhibitionp->getExhibitionsByProduct($product); 
		foreach ($exhibitions as $key => $value) {
			$data[] = $this->findByID($value['exhibitionID']);
		}
		return $data;
	}

}

?>