<?php

Class CommonAction extends Action{

	public function _initialize () {
		session('?unumber') || redirect(U(GROUP_NAME . '/Index/index'));
	}
	
	
	public function playVideo () {
		$this->display();
	}
	
}

?>