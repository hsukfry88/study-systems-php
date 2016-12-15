<?php


Class CommonAction extends Action{

	public function _initialize () {
		session('?uname') || redirect(U(GROUP_NAME . '/Login/index'));
	}

}

?>