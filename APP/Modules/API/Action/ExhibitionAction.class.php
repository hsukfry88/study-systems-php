<?php

Class ExhibitionAction extends Action{

	public function get () {
		$condition = $this->parseCondition();
		$data = $this->executeRequest($condition);
		import('Classes.XMLExhibition',APP_PATH);
		$xmlExhibition = new XMLExhibition();
		$xmlExhibition->add($data);
		$xmlExhibition->saveHTML();
	}

	private function parseCondition () {
		$condition = array(
			'target' => null,
			'starttime' => null,
			);
		$condition['target'] = I('target',null,'htmlspecialchars');
		$condition['starttime'] = I('starttime',null,'htmlspecialchars');
		return $condition;
	}

	private function executeRequest ($condition) {
		if (is_null($condition['target'])) 
			$targetWhere = 'pj_exhibition.id != 0';
		else
			$targetWhere = "pj_exhibition.id in (" . $condition['target'] . ")";
		if (is_null($condition['starttime'])) 
			$starttimeWhere = "pj_exhibition.buildTime != -1";
		else
			$starttimeWhere = "pj_exhibition.bulidTime in (" . $condition['starttime'] . ")";
		$where = array($targetWhere,$starttimeWhere);
		return M('Exhibition')->where($where)->select();
	}

}

?>