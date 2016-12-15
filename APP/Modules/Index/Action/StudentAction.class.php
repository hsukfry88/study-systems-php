<?php


Class StudentAction extends CommonAction{

	/**
	 * 学生界面视图
	 * @param string $mode null 所有作品 true 审核通过作品 false 审核未通过作品
	 */
	public function index ($mode = null) {
		switch ($mode) {
			case "all":	$condition = null;break;
			case "wait":	$condition = false;break;
			case "verified":	$condition = true;break;
		}
		$studentModel = new StudentModel();
		$productModel = new ProductModel();
		$student = $studentModel->findById(session('uid'));
		//首次登陆强制修改个人信息
		if ($student['isUpInfo'] == '0') {
			$this->redirect(GROUP_NAME . '/Student/information');exit;
		}
		//获取作品相关信息
		$product = $productModel->listAllJoinedWithStudent(session('uid'), $condition);
		$product = $this->mergeProduct($product);
		p($product);
		
		$this->assign('mode', $mode);
		$this->assign('student', $student);
		$this->assign('product', $product);
		$this->display();
	}
	
	/**
	 * 重组product数组
	 * @param unknown $product
	 * @return string
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

	/**
	 * 提交作品页视图
	 */
	public function addProduct () {
		$courseModel = new CourseModel();
		$studentModel = new StudentModel();
		$course = $courseModel->listall();
		$user = $studentModel->listDetail();
		$user = $this->mergeUser($user);
		
		$this->assign('course',$course);
		$this->assign('student',$user);
		$this->display();
	}
	
	/**
	 * 重组学生信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	private function mergeUser ($data) {
		$keys = array();
		$user = array();
		foreach ($data as $value) {
			$major = $value['major'];
			$rs = array_search($major, $keys);
			if ($rs === false) {
				$tmp = array();
				$tmp['major'] = $value['majorname'];
				$tmp['people'][] = array(
						'id' => $value['id'],
						'name' => $value['name'],
				);
				$user[] = $tmp;
				$keys[] = $major;
			}else{
				$user[$rs]['people'][] = array(
					'id' => $value['id'],
					'name' => $value['name'],
				);
			}
		}
		return $user;
	}

	
	/**
	 *  作品新增表单处理
	 */
	public function addProductService () {
		set_time_limit(0);
		//POST数据接收
		$data = array();
		$data['name'] = $_POST['name'];
		$data['type'] = $_POST['workType'];
		$data['course'] = $_POST['course'];
		$data['author'] = $_POST['author'];
		$data['joiner'] = $_POST['joiner'];
		$data['teacher'] = $_POST['teacher'];
		$data['intro'] = $_POST['intro'];
		$data['media'] = $_POST['media'];
		$data['subtime'] = time();
		$data['school'] = 3;
		if(array_search(session('uid'), explode("|", $data['author'])) === false) 	$data['author'] = session('uid') . '|' . $data['author'];
		//POST数据验证
		if ($data['name'] == '')	$this->error("作品名不能为空");
		if ($data['course'] == -1)	$this->error("未选择课程");
		//获得文件保存路径
		$filesavepath = $this->getSaveDirectory($data);
		//上传作品缩略图
		$data['thumb'] = $this->uploadThumbProductImg($data,$filesavepath);
		//上传影音文件
		if (!$data['media']) {
			$data['media'] = $this->uploadMedia($data,$filesavepath);
		}
		//上传效果图文件
		$effectpath = $this->uploadEffectFile($data,$filesavepath);
		$data['effectPic'] = json_encode($effectpath);
		//上传其他文件
		if ($rs = $this->uploadOtherFile($data, $filesavepath)) {
			$data['others'] = $rs;
		}
		//上传解说文件
		if ($rs = $this->uploadCommentFile($data, $filesavepath)) {
			$data['commentfile'] = $rs;
		}
		if (!$data['thumb']) {
			$this->error("缩略图上传失败");
		}
		if (!$data['effectPic']) {
			$this->error("效果图上传失败");
		}
		$data['upTime'] = time() + 3600 * 24 * 7;
		
		$productModel = new ProductModel();
		if ($productModel->addProduct($data))
			$this->success("作品添加成功",U(GROUP_NAME . '/Student/index'));
		else
			$this->error("作品添加失败");
	}
	
	/**
	 * 上传作品缩略图
	 */
	private function uploadThumbProductImg ($data, $savepath) {
		if (empty($_FILES))		return false;
		//表单名为thumb
		$x = $_POST['x'];
		$y = $_POST['y'];
		$w = $_POST['w'];
		$h = $_POST['h'];
		//没有文件被上传
		if ($_FILES['thumb']['error'] == 4)		return false;
		$imagetype = str_replace("image/", "", $_FILES['thumb']['type']);
		$functionname = "imagecreatefrom" . $imagetype;
		$src = $functionname($_FILES['thumb']['tmp_name']);
		$dest = imagecreatetruecolor($w, $h);
		if(!imagecopy($dest, $src, 0, 0, $x, $y, $w, $h))	return false;
		
		//文件名
		$productname = 'thumb_' . $data['name'] . date("Y-m-d-H-i-s",$data['subtime']) . '.' . $imagetype;
		//保存图片
		$functionname = "image" . $imagetype;
		$savepath = $savepath . $productname;
		$functionname($dest, iconv('utf-8', 'gbk', $savepath));
		return substr($savepath, 1);
	}
	
	/**
	 * 上传媒体文件
	 * @param unknown $data
	 * @return boolean|string
	 */
	private function uploadMedia ($data, $savepath) {
		//表单名为media
		if (empty($_FILES))		return false;
		if ($_FILES['media']['error'] == 4) 	return false;
		$filetype = substr($_FILES['media']['name'], strrpos($_FILES['media']['name'], '.'));
		
		//文件名
		$productname = $data['name'] . '-' . str_replace($filetype, "", $_FILES['media']['name']) . '-' . date("Y-m-d-H-i-s",$data['subtime']) . $filetype;
		
		$savepath = $savepath . $productname;
		
		//上传文件
		move_uploaded_file($_FILES['media']['tmp_name'], iconv('utf-8', 'gbk', $savepath));
		
		return substr($savepath, 1);
	}
	
	/**
	 * 上传效果图文件
	 * @param unknown $data
	 * @param unknown $savepath
	 * @return boolean
	 */
	private function uploadEffectFile ($data, $savepath) {
		//表单名为effect
		if (empty($_FILES))		return false;
		if ($_FILES['effect']['error'][0] == 4) 	return false;
		$path = array();
		for ($i = 0;$i < count($_FILES['effect']['name']);$i++) {
			$filename = $_FILES['effect']['name'][$i];
			$filetype = substr($filename, strrpos($filename, "."));
			$productname = $data['name'] . '-' . str_replace($filetype, "", $filename) . '-' . date("YmdHis") . $filetype;
			$productpath = $savepath . $productname;
			move_uploaded_file($_FILES['effect']['tmp_name'][$i], iconv('utf-8', 'gbk', $productpath));
			$path[] = substr($productpath, 1);
		}
		return $path;
	}
	
	/**
	 * 上传其他文件
	 * @param unknown $data
	 * @param unknown $savepath
	 * @return boolean|string
	 */
	private function uploadOtherFile ($data, $savepath) {
		//表单名为other
		if (empty($_FILES))		return false;
		if ($_FILES['other']['error'][0] == 4)		return false;
		$filename = $_FILES['other']['name'][0];
		$filetype = substr($filename, strrpos($filename, "."));
		$productname = $data['name'] . '-' . str_replace($filetype, "", $filename) . '-' . date("YmdHis") . $filetype;
		$productpath = $savepath . $productname;
		move_uploaded_file($_FILES['other']['tmp_name'][0], iconv('utf-8', 'gbk', $productpath));
		return substr($productpath, 1);
	}
	
	/**
	 * 上传解说文件
	 * @param unknown $data
	 * @param unknown $savepath
	 * @return boolean|string
	 */
	private function uploadCommentFile ($data, $savepath) {
		//表单名为other
		if (empty($_FILES))		return false;
		if ($_FILES['comment']['error'][0] == 4)		return false;
		$filename = $_FILES['comment']['name'][0];
		$filetype = substr($filename, strrpos($filename, "."));
		$productname = $data['name'] . '-' . str_replace($filetype, "", $filename) . '-' . date("YmdHis") . $filetype;
		$productpath = $savepath . $productname;
		move_uploaded_file($_FILES['comment']['tmp_name'][0], iconv('utf-8', 'gbk', $productpath));
		return substr($productpath, 1);
	}
	
	/**
	 * 获取上传文件保存路径
	 * @param unknown $data
	 * @return string
	 */
	private function getSaveDirectory ($data) {
		//文件上传路径
		$courseModel = new CourseModel();
		$studentModel = new StudentModel();
		//课程文件夹
		$course = $courseModel->findDetailById($data['course']);
		$coursepath = $course['name'] . '-' . $course['teachername'] . '-' . date("Ymd",$course['buildTime']);
		//作品文件夹
		$productpath = $data['name'] . '-';
		foreach (explode("|", $data['author']) as $value) {
			$productpath = $productpath . $studentModel->findById($value)['name'] . '&';
		}
		$productpath = substr($productpath, 0, strlen($productpath)-1);
		$productpath = $productpath . '-' . date("Ymd", $data['subtime']);
		//获得保存路径
		$savepath = C('DEFAULT_FILE_UPLOAD_PATH') . $coursepath . '/' . $productpath . '/';
		//生产目录
		if (!file_exists(iconv('utf8', 'gbk', $savepath))){
			mkdir(iconv('utf-8', 'gbk', $savepath), null, true);
		}
		return $savepath;
	}
	
	

	/**
	 * ��ㄦ�蜂�����淇℃�����缁�
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	private function mergeProduct1 ($data) {
		foreach ($data as $key => $value) {
			$thumb = trim($value['thumb'],'.');
			$thumb = __ROOT__ . $thumb;
			$effectPic = json_decode($value['effectPic']);
			foreach ($effectPic as $k => $v) {
				$tmp = trim($v,'.');
				$tmp = __ROOT__ . $tmp;
				$effectPic[$k] = $tmp;
			}
			$data[$key]['thumb'] = $thumb;
			$data[$key]['effectPic'] = $effectPic;
		}
		return $data;
	}
	
	public function password () {
		$this->display();
	}
	
	/**
	 * 学生个人信息(修改)视图
	 */
	public function information () {
		$studentModel = new StudentModel();
		$student = $studentModel->findById(session('uid'));
		
		$this->assign('student',$student);
		$this->display();
	}
	
	/**
	 * 学生个人信息修改表单处理
	 */
	public function updateInfo () {
		if ($_POST['npwd'] != $_POST['cpwd']) $this->error("两次密码不一致");
		$model = new StudentModel();
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
		$this->redirect(GROUP_NAME . '/Student/index');
	}
	
	/**
	 * 截图表单处理
	 */
	public function screenShot () {
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
		$path = C('HEAD_PATH') . session('urole') . '/' . D(session('urole'))->findById(session('uid'))['number'] . '.' . $imagetype;
		$functionname($dest,$path);
		$path = substr($path, 1,count($path)-1);
		return $path;
	}

}

?>