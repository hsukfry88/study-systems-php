<?php

Class LeaderAction extends CommonAction{

	/**
	 * 领导主页视图
	 */
	public function index () {
		$teacherModel = new TeacherModel();
		$teacher = $teacherModel->findById(session('uid'));
		if ($teacher['isUpInfo'] == '0') 	{
			$this->redirect(GROUP_NAME . "/Leader/information");exit;
		}
	
	}
	
	/**
	 * 领导个人信息（修改）视图
	 */
	public function information () {
		$teacherModel = new TeacherModel();
		$teacher = $teacherModel->findById(session('uid'));
		
		$this->assign('teacher',$teacher);
		$this->display();
	}
	
	/**
	 * 个人信息修改表单处理
	 */
	public function updateInfo () {
		if ($_POST['npwd'] != $_POST['cpwd']) $this->error("两次密码不一致");
		$model = new TeacherModel();
		$user = $model->findById(session('uid'));
		if($user['password'] != md5($_POST['opwd']))	$this->error("初始密码错误");
		$rs = $model->findByMail($_POST['mail']);
		if ($rs && $rs['mail'] != $_POST['mail'])	$this->error("该邮箱已被占用");
		$rs = $model->findByPhone($_POST['phone']);
		if ($rs && $rs['phone'] != $_POST['phone']) 	$this->error("改电话已被占用");
		$path = $this->screenShot();
		$user['phone'] = $_POST['phone'];
		$user['mail'] = $_POST['mail'];
		$user['qq'] = $_POST['qq'];
		$user['brief'] = $_POST['brief'];
		if ($path != null)	$user['head'] = $path;
		$user['password'] = md5($_POST['npwd']);
		$user['isUpInfo'] = 1;
		$model->modify($user['id'], $user);
		$this->redirect(GROUP_NAME . '/Leader/index');
	}
	
	/**
	 * 截图表单处理
	 */
	private function screenShot () {
		if ($_FILES['imgfile']['name'] == '')	return null;
		$imagetype = $_FILES['imgfile']['type'];
		$imagetype = str_replace('image/', '',$imagetype);
		$functionname = 'imagecreatefrom' . $imagetype;
		$tmppath = $_FILES['imgfile']['tmp_name'];
		$resource = $functionname($tmppath);
		$w = $_POST['w'];
		$h = $_POST['h'];
		$x = $_POST['x'];
		$y = $_POST['y'];
		$dest = imagecreatetruecolor($w, $h);
		imagecopy($dest, $resource, 0, 0, $x, $y, $w, $h);
		$functionname = 'image' . $imagetype;
		$path = C('HEAD_PATH') . session('urole') . '/';
		if (!file_exists($path))	mkdir($path,0777,true);
		$savepath = $path . D('Teacher')->findById(session('uid'))['number'] . '.' . $imagetype;
		$functionname($dest,$savepath);
		$savepath = substr($savepath, 1,strlen($savepath)-1);
		return $savepath;
	}

	/**
	 * 展厅添加视图
	 */
	public function addExhibition () {
		$this->display();
	}
	
	/**
	 * 展厅添加表单处理
	 */
	public function addExhibitionService () {
		$data = array();
		$data['name'] = $_POST['name'];
		$data['EndTime'] = strtotime($_POST['EntTime']);
		$data['remark'] = $_POST['intro'];
		$data['status'] = "PUBLIC";
		$data['school'] = 3;
		$data['sponsor'] = session('uid');
		if (strlen($data['name']) > 15*3)	$this->error("展厅名长度大于15个字符");
		if ($data['name'] == "")		$this->error("展厅名不能为空");
		if ($data['EndTime'] < time())		$this->error("提交日期不能早于今天");
		$exhibitionSavePath = $this->exhibitionDirectoryPath($data);
		$data['thumb'] = $this->exhibitionThumbImage($exhibitionSavePath,$data);
		if (!$data['thumb']) 	$this->error("展厅缩略图上传失败");
		if ($rs = $this->exhibitionCommentFile($exhibitionSavePath,$data))		$data['commentfile'] = $rs;
		
		$exhibitionModel = new ExhibitionModel();
		$exhibitionModel->addExhibition($data);
		$this->success("添加成功",GROUP_NAME . '/Leader/index');
	}
	
	/**
	 * 获取展厅保存路径
	 * @param unknown $data
	 * @return string
	 */
	private function exhibitionDirectoryPath ($data) {
		$path = C('DEFAULT_EXHIBITION_PATH') . $data['name'] . '-' . session('uname') . '-' . date("Ymd",$data['EndTime']) . '/';
		(!file_exists(iconv('utf-8', 'gbk', $path))) && mkdir(iconv('utf-8', 'gbk', $path),0777,true);
		return $path;
	}
	
	/**
	 * 展厅缩略图处理
	 * @param unknown $path
	 * @param unknown $data
	 * @return NULL|string
	 */
	private function exhibitionThumbImage ($path,$data) {
		if ($_FILES['imgfile']['name'] == '')	return null;
		$imagetype = $_FILES['imgfile']['type'];
		$imagetype = str_replace('image/', '',$imagetype);
		$functionname = 'imagecreatefrom' . $imagetype;
		$tmppath = $_FILES['imgfile']['tmp_name'];
		$resource = $functionname($tmppath);
		$w = $_POST['w'];
		$h = $_POST['h'];
		$x = $_POST['x'];
		$y = $_POST['y'];
		$dest = imagecreatetruecolor($w, $h);
		imagecopy($dest, $resource, 0, 0, $x, $y, $w, $h);
		$functionname = 'image' . $imagetype;
		$filename = 'thumb_' . $data['name'] . '-' . date("Ymd-H-i-s",time()) . '.' . $imagetype;
		$path = $path . $filename;
		$functionname($dest,iconv('utf-8', 'gbk', $path));
		$path = substr($path, 1);
		return $path;
	}
	
	/**
	 * 展厅解说文件上传处理
	 * @param unknown $path
	 * @param unknown $data
	 * @return boolean|string
	 */
	private function exhibitionCommentFile ($path,$data) {
		if ($_FILES['soundFlie']['error'] == 4) 	return false;
		if (strpos($_FILES['soundFlie']['type'], 'audio') === false)	return false;
		$filetype = substr($_FILES['soundFlie']['name'], strrpos($_FILES['soundFlie']['name'], '.'));
		$filename = "解说文件_" . $data['name'] . '_' . date("Ymd-H-i-s",time()) . $filetype;
		$filepath = $path . $filename;
		move_uploaded_file($_FILES['soundFlie']['tmp_name'], iconv('utf-8', 'gbk', $filepath));
		return substr($filepath, 1);
	}

	/**
	 * 展厅列表
	 */
	public function individual () {
		$teacherModel = new TeacherModel();
		$exhibitionModel = new ExhibitionModel();
		
		$teacher = $teacherModel->findById(session('uid'));
		$exhibitions = $exhibitionModel->listAllByLeader(2);

		$this->assign('teacher',$teacher);
		$this->assign('exhibitions', $exhibitions);
		//p($exhibitions);
		$this->display();
	}

	//@param string $mode null 所有作品 true 审核通过作品 false 审核未通过作品
	public function showRoom ($id, $mode = 'all') {
		$condition = null;
		switch ($mode) {
			case 'all':$condition = null;break;
			case 'verifed':$condition = true;break;
			case 'wait':$condition = false;break;
		}
		
		$teacherModel = new TeacherModel();
		$exhibitionModel = new ExhibitionModel();
		
		$teacher = $teacherModel->findById(session('uid'));
		$exhibition = $exhibitionModel->findByID($id);
		$products = $exhibitionModel->getProductsByExhibition($exhibition['id'], $condition);
		$products = $this->mergeProduct($products);
		$verify=$exhibitionModel->readExhibitionProductList($id);
		
		//p($verify);
		
		//p($products);
		$this->assign('teacher', $teacher);
		$this->assign('exhibition', $exhibition);
		$this->assign('products', $products);
		$this->assign('verify',$verify);
		$this->display();
	}
	
	
		/**
	 * 重组product数组
	 * @param unknown $product
	 * @return unknown
	 */
	private function mergeProduct ($product) {
		$studentModel = new StudentModel();
		foreach ($product as $key => $value) {
			//得到效果图和影音文件信息列
			$photos = array();
			$json = array();
			foreach (json_decode($value['effectPic']) as $k => $v) {
				$photos[] = array(
					'name' => substr($v, strrpos($v, "/")+1,strrpos($v, ".")-strrpos($v, "/")-1),
					'url' => $v,
				);
			}
			$value['medium']['photo'] = $photos;
			$videos = array();
			$videos[] = array(
				'name' => substr($value['media'], strrpos($value['media'], "/")+1,strrpos($value['media'], ".")-strrpos($value['media'], "/")-1),
				'url' => $value['media'],
			);
			if ($value['media'] != "") 		$value['medium']['video'] = $videos;
			
			
			//得到作者和参与人信息列
			$author = array();
			foreach (explode("|", $value['author']) as $k => $v) {
				$author[] = $studentModel->getDetailById($v);
			}
			$value['author'] = $author;
			$joiner = array();
			foreach (explode("|", $value['joiner']) as $k => $v) {
				$joiner[] = $studentModel->getDetailById($v);
			}
			$value['joiner'] = $joiner;
			
			
			//得到json数据
			foreach ($photos as $k => $v) {
				$json[] = array(
					'name' => $v['name'],
					'url' => $v['url'],
					'type' => '1',
				);
			}
			foreach ($videos as $k => $v) {
				$json[] = array(
					'name' => $v['name'],
					'url' => $v['url'],
					'type' => '2',
				);
			}
			
			//$value['mediumjson'] = $json;
			$value['mediumjson'] = json_encode($json);
			$value['authorjson'] = json_encode($value['author']);
			$value['joinerjson'] = json_encode($value['joniner']);
			
			$product[$key] = $value;
		}
		return $product;
	}
	
	
	
	private function mergeExhibition ($exhibition) {
		foreach ($exhibition as $key => $value) {
			$exhibition[$key]['thumb'] = __ROOT__ . trim($value['thumb'],'.');
		}	
		return $exhibition;
	}

	public function exhibition ($id) {
		$products = D('Exhibitionp')->getProductionByExhibition($id);
		$products = $this->mergeEProduction($products);
		$leader = D('Teacher')->getDetailById(session('uid'));
		//p($products);
		$this->assign('products',$products);
		$this->assign('leader',$leader);
		$this->display();
	}

	public function verify () {
		$exhibition = I('exhibition',0,'htmlspecialchars');
		$product = I('product',0,'htmlspecialchars');
		D('Exhibitionp')->verify($product,$exhibition);
		$this->redirect(GROUP_NAME . '/Leader/exhibition',array('id'=>$exhibition));
	}

	public function remove () {
		$exhibition = I('exhibition',0,'htmlspecialchars');
		$product = I('product',0,'htmlspecialchars');
		D('Exhibitionp')->remove($product,$exhibition);
		$this->redirect(GROUP_NAME . '/Leader/exhibition',array('id'=>$exhibition));
	}

	private function mergeEProduction ($exhibition) {
		foreach ($exhibition as $key => $value) {
			$exhibition[$key]['product']['thumb'] = __ROOT__ . trim($value['product']['thumb'],'.');
			$effect = json_decode($value['product']['effectPic']);
			foreach ($effect as $k => $v) {
				$effect[$k] =  __ROOT__ . trim($v,'.');
			}
			$exhibition[$key]['product']['effectPic'] = $effect;
			foreach ($value['product']['author'] as $k => $v) {
				$exhibition[$key]['product']['author'][$k] = array('name' => $v['name']);
			}
		}
		return $exhibition;
	}
	
	//通过展厅审核
	public function agreeSubmit(){
			if (D('Product')->agreeVerify($_POST['EXWorkeId'])) {
				D('Exhibitionp')->verify($_POST['EXWorkeId']);
				$this->success('恭喜您，加入展厅成功');
				
			}else{
				
				$this->error('很抱歉，加入展厅操作失败');
			}
	}
	
}

?>