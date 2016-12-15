<?php

Class TeacherAction extends CommonAction{

	/**
	 * 教师主页视图，快捷操作
	 * @return [type] [description]
	 */
	public function index () {
		$model = new TeacherModel();
		$teacher = $model->findById(session('uid'));
		if ($teacher['isUpInfo'] == 0) {
			$this->redirect(GROUP_NAME . '/Teacher/information');
			return;
		}
		$this->display();
	}


	/**
	 * 个人中心视图
	 * @return [type] [description]
	 */
	public function individual ($major = null) {
		$teacherModel = new TeacherModel();
		$courseModel = new CourseModel();
		$productModel = new ProductModel();
		
		$teacher = $teacherModel->findById(session('uid'));
		$course = $courseModel->listall();
		$condition = $major;
		if ($major == 'all') 	$condition = null;
		$product = $productModel->listAllWithTeacherAndMajor(session('uid'), $condition);
		$product = $this->mergeProduct($product);
		$exhibition=$productModel->readExhibitionList();
		//p($exhibition);
		$this->assign('exhibition',$exhibition);
		
		//p($product);
		$this->assign('teacher',$teacher);
		$this->assign('course', $course);
		$this->assign('product',$product);
		$this->assign('major', $major);
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
	
	
	
	

	/**
	 * 教师课程新增视图
	 */
	public function addClass () {
		$typeModel = new TypeModel();
		$type = $typeModel->listing();
		
		$this->assign('type',$type);
		$this->display();
	}
	
	/**
	 * 添加课程表单处理
	 */
	public function addClassService () {
		$data = array();
		$data['name'] = $_POST['course'];
		$data['submitTime'] = strtotime($_POST['EntTime']);
		$data['type'] = $_POST['option1'];
		$data['brief'] = $_POST['intro'];
		$data['buildTime'] = time();
		$data['teacher'] = session('uid');
		$data['school'] = 3;
		if ($data['name'] == "") 	$this->error("课程名不能为空");
		if ($data['type'] == -1) 	$this->error("未选择作品类型");
		if ($data['submitTime'] < $data['buildTime']) 	$this->error("作品提交时间不能早于当前时间");
		$courseModel = new CourseModel();
		$courseModel->addCourse($data);
		$this->success("添加成功",U(GROUP_NAME . '/Teacher/individual'));
	}
	

	public function recomand () {
		$product = I('product',0,'htmlspecialchars');
		$exhibition = I('exhibition',0,'htmlspecialchars');
		if (D('Exhibitionp')->append($product,$exhibition)) {
			$this->success('推荐成功',U(GROUP_NAME . '/Teacher/individual'));
		}else{
			$this->error('推荐失败');
		}
	}

	public function grade ($product,$grade) {
		$product = I('product',0,'htmlspecialchars');
		$exhibition = I('exhibition',0,'htmlspecialchars');
		$grade = I('grade',0,'htmlspecialchars');
		D('Product')->grade($product,$grade);
		$this->redirect('/Teacher/individual');
	}

	/**
	 * 下载作品
	 * @param unknown $major
	 */
	public function downloadProduct ($major) {
		
	}
	
	/**
	 * 生成成绩报表
	 */
	public function createReport () {
		$productModel = new ProductModel();
		$product = $productModel->listAllWithTeacherAndMajor(session('uid'));
		$product = $this->mergeProduct($product);
		import('Classes.PHPExcel.IOFactory',APP_PATH,'.php');
		
		p($product);
	}
	
	
// 	private function mergeProduct ($data) {
// 		foreach ($data as $key => $value) {
// 			$effectPic = json_decode($value['effectPic']);
// 			foreach ($effectPic as $k => $v) {
// 				$v = __ROOT__ . trim($v,'.');
// 				$effectPic[$k] = $v;
// 			}
// 			$data[$key]['effectPic'] = $effectPic;
// 		}
// 		return $data;
// 	}
	
	
	/**
	 * 教师个人信息（修改）视图
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
		$this->redirect(GROUP_NAME . '/Teacher/index');
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
		$path = C('HEAD_PATH') . session('urole') . '/';
		if (!file_exists($path))	mkdir($path,0777,true);
		$savepath = $path . D(session('urole'))->findById(session('uid'))['number'] . '.' . $imagetype;
		$functionname($dest,$savepath);
		$savepath = substr($savepath, 1,strlen($savepath)-1);
		return $savepath;
	}
	
	
	/**
	 * 教师点评作品,打分插入数据库
	 */
	public function gradeWorke () {
		$workeId=$_POST['workeId'];
		$data=array();
		$data['grade']=$_POST['grade'];
		$data['comment']=$_POST['comment'];
		$wodkeGrade=new ProductModel();
		if($wodkeGrade->grade($workeId,$data)){
				$this->success('操作成功',U(GROUP_NAME . '/Teacher/individual'));
		}
		if($_POST['submitEX']==2 ){
			//$exhibition=$_POST['selectEx'];
			if (D('Exhibitionp')->append($_POST['workeId'],$_POST['selectEx'])) {
				$this->success('推荐成功',U(GROUP_NAME . '/Teacher/individual'));
			}else{
				$this->error('亲爱的老师，您可能忘记选择展厅了呦');
			}
			
		}
		$this->redirect(GROUP_NAME . '/Teacher/individual');
		
		
		
		
	}
	
	
	/**
	*教师删除作品功能
	*/
	
	public function deleteWorke(){
		$ProductDb=new ProductModel();
		//$data = array('id' => $_POST['deleteWorkeName']);
		$ProductDb->deleteProductInfo($_POST['deleteWorkeName']);
		//$this->redirect(GROUP_NAME . '/Teacher/individual');
	}
	

}

?>