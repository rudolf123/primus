<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	
        public $layout='//layouts/main';

        public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
        public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				//'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
                                'actions'=>array('index','view','admin'),
				'users'=>array('?'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
            if(Yii::app()->user->isGuest)	
                $this->render('index');
            if(Yii::app()->user->checkAccess('moderator'))
            {
                $dataProvider = new CActiveDataProvider('User', array(
                                    'criteria' => array(
                                    'condition' => 'online = :param_online',// AND TIME_TO_SEC(TIMEDIFF(NOW(),sessionend))<100',
                                    'params' => array(':param_online' => 1),
                                    ),
                ));
                $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                $model->section = 'Преподаватель';
                $model->save();
                $this->render('indexmoderator',array(
                        'dataProvider'=>$dataProvider,
                        ),false,true);
            }
            else
                if(Yii::app()->user->checkAccess('user'))	
                {
                    $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                    $model->section = 'Начальная страница';
                    $model->save();
                    $this->render('indexuser');
                }
                
        }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

        public function actionAdmin()
        {
            $this->render('adminview');
        }
        
        public function actionEditHelptreetitle() 
        {
            $pk = Yii::app()->request->getPost('pk');
            $name = Yii::app()->request->getPost('name');
            $value = Yii::app()->request->getPost('value');
            $model = Helptree::model()->findByPk($pk);
            if($model===null)
                throw new CHttpException(400);
            $model->$name = $value;
            if ($model->validate())
                $model->save();
        }  
        
        public function actionEditTrainingtreetitle() 
        {
            $pk = Yii::app()->request->getPost('pk');
            $name = Yii::app()->request->getPost('name');
            $value = Yii::app()->request->getPost('value');
            $model = Trainingtree::model()->findByPk($pk);
            if($model===null)
                throw new CHttpException(400);
            $model->$name = $value;
            if ($model->validate())
                $model->save();
        }  
        
        public function actionDeleteHelptree($id) 
        {
            $model = Helptree::model()->findByPk($id);
            $submodels = Helptree::model()->findAllByAttributes(array('parent_id'=>$id));
            foreach ($submodels as $submodel)
                $submodel->delete();
            $model->delete();
        }  
        
        public function actionDeleteTrainingtree($id) 
        {
            $model = Trainingtree::model()->findByPk($id);
            $submodels = Trainingtree::model()->findAllByAttributes(array('parent_id'=>$id));
            foreach ($submodels as $submodel)
                $submodel->delete();
            $model->delete();
        }  
        
        public function actionLoadqst() 
        {
            $fileR = fopen('questions1.txt', 'r');
            $fileWtest = fopen('questionsTest.txt', 'w');
            $fileW = fopen('logparse.txt', 'w');
            $theme = '';
            $qtext = '';
            $atext = array();
            $i = 0;
            $j = 0;
            $flag = 0;
            $testtree_id = 0;
            $testquestionmodel;
            while (!feof($fileR))
            {
                $data = fgets($fileR,999); 
                $i++;

                if (strpos($data,'1.')===0)
                {
                    fwrite($fileW, $data);
                    array_push($atext, $data);
                    continue;
                }
                if (strpos($data,'2.')===0)
                {
                    fwrite($fileW, $data);
                    array_push($atext, $data);
                    continue;
                }
                if (strpos($data,'3.')===0)
                {
                    fwrite($fileW, $data);
                    array_push($atext, $data);
                    continue;
                }
                if (strpos($data,'4.')===0)
                {
                    fwrite($fileW, $data);
                    array_push($atext, $data);
                    continue;
                }
                if (strpos($data,'5.')===0)
                {
                    fwrite($fileW, $data);
                    array_push($atext, $data);
                    continue;
                }
                if (strpos($data,'6.')===0)
                {
                    fwrite($fileW, $data);
                    array_push($atext, $data);
                    continue;
                }
                $flag++;
                if ($qtext!=='' && $flag>2)
                {
                    $model = new Question;
                    $model->theme = $theme;
                    $model->text = $qtext;
                    $model->rate = rand(1,10)/10;
                    $question_id = 0;
                    if ($model->save())
                        $question_id = $model->id;
                    fwrite($fileWtest, 'themeTitle: '.$theme);
                    fwrite($fileWtest, 'questiontxt: '.$qtext);
                    $testquestionmodel = new Testquestion;
                    $testquestionmodel->question_id = $question_id;
                    $testquestionmodel->test_id = $testtree_id;
                    $testquestionmodel->save();
                    
                    $count = 0;
                    foreach ($atext as $answr)
                    {
                        $modelAnswr = new Answer;
                        $count++;
                        fwrite ($fileWtest, 'answer: '.$answr);
                        $modelAnswr->text = substr($answr,2);
                        if ($count===1)
                            $modelAnswr->isright = 1;
                        else
                            $modelAnswr->isright = 0;
                        $modelAnswr->question_id = $question_id;
                        $modelAnswr->save();
                    }
                    $qtext = '';
                    array_splice($atext, 0);
                }
                if (strpos($data,'Тестовые вопросы по')===0)
                {
                    echo $flag.$data;
                    echo '<br />';
                    $theme = $data;
                    $model = new Testtree;
                    $model->title = $data;
                    $model->type = 1;
                    $model->time = 10;
                    $model->icon = 'table.png';
                    if ($model->save())
                    {
                        $model->url = '/testtree/viewTest/'.$model->id;
                        $model->save();
                        
                        $testtree_id = $model->id;
                    }
                    fwrite($fileW, $data);
                    continue;
                }
                $qtext = $data;
                
                
                fwrite($fileW, '::'.$data);
                

            }
            fwrite($fileWtest, 'themeTitle: '.$theme);
            fwrite($fileWtest, 'questiontxt: '.$qtext);
            foreach ($atext as $answr)
                fwrite ($fileWtest, 'answer: '.$answr);
            $qtext = '';
            array_splice($atext, 0);
            echo $j.'  ';
            fclose($fileR);
            fclose($fileW);
            fclose($fileWtest);
            
        }  
        
        public function actionMakemoderator($id)
        {
            $user = User::model()->findByPk($id);
            if ($user->role == 'user')
                $user->role = 'moderator';
            else
                $user->role = 'user';
            $user->save();
            $this->render('userview', array('model'=>$user));
        }
        
        public function actionDeleteuser($id)
        {
            $user = User::model()->findByPk($id);
            $user->delete();
            
            $this->render('adminview');
        }
        
        public function actionViewuser($id)
        {
            $user = User::model()->findByPk($id);
            $testdataprovider = new CActiveDataProvider('Userlog', array(
                    'criteria' => array(
                    'condition' => 'user_id = :param_user_id',// AND TIME_TO_SEC(TIMEDIFF(NOW(),sessionend))<100',
                    'params' => array(':param_user_id' => $id),
                    ),
            ));
            $this->render('userview', array('model'=>$user,'testdataprovider'=>$testdataprovider));
        }
        
        public function actionViewanswerslog($id)
        {
            $dataprovider = new CActiveDataProvider('Userloganswers', array(
                    'criteria' => array(
                    'condition' => 'userlog_id = :param_userlog_id',// AND TIME_TO_SEC(TIMEDIFF(NOW(),sessionend))<100',
                    'params' => array(':param_userlog_id' => $id),
                    ),
            ));
            $this->render('userviewanswerslog', array('dataprovider'=>$dataprovider));
        }

        public function actionDeletetestlog($id)
        {
		$model=Userlog::model()->findByPk($id);
                $modelsecondary = Userloganswers::model()->findAllByAttributes(array('userlog_id'=>$model->id));
                foreach ($modelsecondary as $secondary)
                {
                    $secondary->delete();
                }
                $model->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
      
        public function actionAdminsections()
        {
            $modelHelp = Helptree::model()->findAll();
            $modelTrain = Trainingtree::model()->findAll();
            $dataProviderHelp = new CActiveDataProvider('Helptree', array());
            $dataProviderTrain = new CActiveDataProvider('Trainingtree', array());
            $this->render('adminsectionsview', array('modelHelp'=>$dataProviderHelp,
                                                     'modelTrain'=>$dataProviderTrain,   
                                        ));
        }
        
        public function actionAdminsectionsAjax()
        {
            $modelHelp = Helptree::model()->findAll();
            $modelTrain = Trainingtree::model()->findAll();
            $dataProviderHelp = new CActiveDataProvider('Helptree', array());
            $dataProviderTrain = new CActiveDataProvider('Trainingtree', array());
            $this->render('_adminsectionsview', array('modelHelp'=>$dataProviderHelp,
                                                     'modelTrain'=>$dataProviderTrain,   
                                        ));
        }

        public function actionLogin()
	{
            $this->redirect('../user/login');
	}
        
        public function actionHelp()
        {
            $model=new Helptree;
            $dataProvider=new CActiveDataProvider('Helptree');
            $this->render('help',array(
			'dataProvider'=>$dataProvider,
                ));
        }
        
        public function actionCreateFolder()
        {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/storage/', 0777);
        }
        
        public function actionFileBrowser()
	{
		$root = '/';
		
		$_POST['dir'] = urldecode($_POST['dir']);

		if( file_exists($root . $_POST['dir']) ) {
			$files = scandir($root . $_POST['dir']);
			natcasesort($files);
			if( count($files) > 2 ) { /* The 2 accounts for . and .. */
				echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				// All dirs
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
						echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
					}
				}
				// All files
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
						$ext = preg_replace('/^.*\./', '', $file);
						echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
					}
				}
				echo "</ul>";	
			}
		}
	}
        
}