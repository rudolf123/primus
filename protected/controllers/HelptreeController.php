<?php

class HelptreeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $treenodeid;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
        
        public function actions()
        {
            return array(
                'fileUploaderConnector' => "ext.ezzeelfinder.ElFinderConnectorAction",
            );
        }

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
                        array('deny',  // deny all users
                                'actions'=>array('index','view'),
				'users'=>array('?'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','downloadfile'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete'),
				'roles'=>array('Moderator')
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            //$file = fopen('dffghfg.txt','a');
            //fwrite($file, $this->createAbsoluteUrl('test/test',array('id'=>$id)));
            //fclose($file);
		if(Yii::app()->request->isAjaxRequest)
                    if (Yii::app()->user->isGuest)
                        $this->renderPartial('../user/login');
                    else
			$this->renderPartial('view',array(
				'model'=>$this->loadModel($id),
			),false,true);
		else
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Helptree;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
                
                if(isset($_POST['Helptree']))
		{
			$model->attributes=$_POST['Helptree'];
                        $model->type=$_POST['Helptree']['etype'];
                        $model->htmlfield = $_POST['Helptree']['htmlfield'];
                        if ($model->type==0)
                            $model->icon='folder_key.png';
                        if ($model->type==1)
                            $model->icon='table.png';
                        
			if($model->save())
                        {
                            if ($model->type==1)
                            {
                                $model->url = '/helptree/view/'.$model->id;
                                $model->save();
                                $this->redirect('../'.$model->url);
                            }
                        }
		}
               
                $this->render('create',array(
                        'model'=>$model,
                        'backurl'=>$_GET['backurl']
		));
	}
        
        public function actionCreateFolder()
	{
		$model=new Helptree;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
                
		if(isset($_POST['Helptree']))
		{
                    $file1 = fopen('log1678.txt','a');
			$model->attributes=$_POST['Helptree'];
                        $model->type=$_POST['Helptree']['etype'];
                        fwrite($file1,'ActionCreatefolder');
                        fclose($file1);
                        if ($model->type==0)
                            $model->icon='folder_key.png';
                        if ($model->type==1)
                            $model->icon='table.png';
                        if($model->save())
                        {
                            if (isset($_GET['backurl']))
                                $this->redirect($_GET['backurl']);
                            else 
                                $this->redirect('../helptree/index');
                                
                            
                        }
                        else
                            $this->redirect('../site/error');
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

        public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                if (isset($_GET['deletefile']))
                {
                    if ($_GET['deletefile'] === 'doc')
                    {
                        @unlink($_SERVER['DOCUMENT_ROOT'].'/storage/'.$model->doc);
                        $model->doc = '';
                        $model->save();
                    }
                    if ($_GET['deletefile'] === 'img')
                    {
                        @unlink($_SERVER['DOCUMENT_ROOT'].'/storage/'.$model->img);
                        $model->img = '';
                        $model->save();
                    }
                    if ($_GET['deletefile'] === 'pdf')
                    {
                        @unlink($_SERVER['DOCUMENT_ROOT'].'/storage/'.$model->pdf);
                        $model->pdf = '';
                        $model->save();
                    }
                    if ($_GET['deletefile'] === 'video')
                    {
                        @unlink($_SERVER['DOCUMENT_ROOT'].'/storage/'.$model->video);
                        $model->video = '';
                        $model->save();
                    }
                }
                
		if(isset($_POST['Helptree']))
		{
			$model->attributes=$_POST['Helptree'];
                        $model->htmlfield = $_POST['Helptree']['htmlfield'];

			if($model->save())
                        {
				$this->redirect('../view/'.$model->id);
                        }
		}

		$this->render('update',array(
			'model'=>$model,
                        'backurl'=>$_GET['backurl'],
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            $this->loadModel($id)->delete();
            $this->redirect('../index');
        }
        
        public function actionAjaxdeletepic($name)
        {
            $file = fopen('logdeleteajax.txt','a');
            fwrite($file, $name);
            fclose($file);
        }

        /**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Helptree');
                
                if(Yii::app()->user->checkAccess('user'))
                {
                    $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                    $model->section = 'Изучает информационную справку';
                    $model->save();
                }
        
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
                //логи
               // $file = fopen('log.txt',a);
                //$text = date("Y-d-m H:i:s")." ".getenv("HTTP_REFERER")." IP - ".getenv("REMOTE_ADDR")."\r\n";
               // fwrite($file,$text);
               // fclose($file);
	}

        public function actionAjaxUpdate($id)
        {
            if (isset($_GET['add_qid']))
            {
                $testquestion = new Helpquestion;
                $testquestion->help_id = $id;
                $testquestion->question_id = $_GET['add_qid'];
                $testquestion->save();

                $testquestions = Helpquestion::model()->findAllByAttributes(array('help_id'=>$id));
                $count_questions = count($testquestions);
                if($count_questions > 0){
                    $arr_questions = array();
                    foreach($testquestions as $testquestion)
                        array_push($arr_questions,$testquestion->question_id);
                }
                $criteria = new CDbCriteria();
                $criteria1 = new CDbCriteria();
                $criteria1->addInCondition('id', $arr_questions);
                $questionsintest = new CActiveDataProvider('Question', array(
                   'criteria' => $criteria1));
                $criteria->addNotInCondition('id', $arr_questions);
                $dataProvider = new CActiveDataProvider('Question', array(
                   'criteria' => $criteria));
            }
            
            if (isset($_GET['rem_qid']))
            {
                Helpquestion::model()->deleteAll(
                                    'help_id = :param_test_id AND question_id=:param_question_id',
                                    array(
                                        ':param_test_id' => $id,
                                        ':param_question_id' => $_GET['rem_qid'],
                                        ));
            
                $testquestions = Helpquestion::model()->findAllByAttributes(array('help_id'=>$id));
                $count_questions = count($testquestions);
                if($count_questions > 0){
                    $arr_questions = array();
                    foreach($testquestions as $testquestion)
                        array_push($arr_questions,$testquestion->question_id);
                }
                $criteria = new CDbCriteria();
                $criteria1 = new CDbCriteria();
                $criteria1->addInCondition('id', $arr_questions);
                $questionsintest = new CActiveDataProvider('Question', array(
                   'criteria' => $criteria1));
                $criteria->addNotInCondition('id', $arr_questions);
                $dataProvider = new CActiveDataProvider('Question', array(
                   'criteria' => $criteria));
            }
        }
        
        public function actionManageQuestions($id)
        {
                $model = $this->loadModel($id);
                
                $testquestions = Helpquestion::model()->findAllByAttributes(array('help_id'=>$id));
                $count_questions = count($testquestions);
                if($count_questions > 0){
                    $arr_questions = array();
                    foreach($testquestions as $testquestion)
                        array_push($arr_questions,$testquestion->question_id);
                }
                $criteria = new CDbCriteria();
                $criteria1 = new CDbCriteria();
                $criteria1->addInCondition('id', $arr_questions);
                $questionsintest = new CActiveDataProvider('Question', array(
                   'criteria' => $criteria1));
                
                $criteria->addNotInCondition('id', $arr_questions);

                $dataProvider = new CActiveDataProvider('Question', array(
                   'criteria' => $criteria));

                $this->render('updatetest',array(
                        'model'=>$model,
                        'dataProvider'=>$dataProvider,
                        'testquestions'=>$questionsintest,
                        'backurl'=>$_GET['backurl'],
                        ),false,true);
        }
        
        public function actionRunTest($id)
        {
            $testquestions = Helpquestion::model()->findAllByAttributes(array('help_id'=>$id));
            $testtreemodel = Helptree::model()->findByPk($id);
            $count_questions = count($testquestions);
            if($count_questions > 0){
                $arr_questions_ids = array();
                foreach($testquestions as $testquestion)
                    array_push($arr_questions_ids,$testquestion->question_id);
            }
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $arr_questions_ids);
            $questions = Question::model()->findAll($criteria);
            $qmodel = new QuestionForm;

            $userlogcount = count(Userloghelp::model()->findByAttributes(array('test_id'=>$id, 'user_id'=>Yii::app()->user->id)));
           // if (count($userlogcount)==0)
            
            $userlog = new Userloghelp;            
            $userlog->test_id = $id;
            $userlog->user_id = Yii::app()->user->id;
            $userlog->grade = -1;
            $userlog->starttime = date('Y-m-d H:i:s', time());
            $userlog->save();

            $this->render('runtest', array(
                        'questions'=>$questions,
                        'model'=>$qmodel,
                        'testtreemodel'=>$testtreemodel,
                        'userlogcount'=>$userlogcount,
                        'userlog_id'=>$userlog->id,
                        ), false, true);
        }
        
        public function actionAjax($userlog_id)
        {
                if(isset($_POST['QuestionForm']))
                {
                    $userlog = Userloghelp::model()->findByPk($userlog_id);
                    $userlog->endtime = date('Y-m-d H:i:s', time());
                    
                    $rightanswer_counter = 0;
                    $grade = 0;

                    if(isset($_POST['QuestionForm']['answers']))
                        foreach ($_POST['QuestionForm']['answers'] as $attr)
                        {
                            list($question_id, $answer_id) = explode(";", $attr);
                            $checkquestion  = Question::model()->findByPk($question_id);
                            $checkanswer = Answer::model()->findByAttributes(array('question_id'=>$question_id,'id'=>$answer_id));
                            if ($checkanswer->isright)
                            {
                                $rightanswer_counter++;
                                $grade += $checkquestion->rate; 
                            }
                            $userloganswers = new Userloganswershelp;
                            $userloganswers->answer_id = $answer_id;
                            $userloganswers->answer_text = $checkanswer->text;
                            $userloganswers->question_text = $checkquestion->text;
                            $userloganswers->question_id = $question_id;
                            $userloganswers->userlog_id = $userlog_id;
                            $userloganswers->isright = $checkanswer->isright;
                            $right_answer_text = Answer::model()->findByAttributes(array('question_id'=>$question_id, 'isright'=>1))->text;
                            $userloganswers->right_answer = $right_answer_text;
                            $userloganswers->save();
                        }

                    $question_count = count(Helpquestion::model()->findAllByAttributes(array('help_id'=>$_POST['QuestionForm']['test_id'])));
                    $grade /= $question_count;
                    $userlog->grade = round($grade,2);
                    $userlog->save();
                    $answerslog = new CActiveDataProvider('Userloganswershelp', array(
                                        'criteria' => array(
                                        'condition' => 'userlog_id = :param_userlog_id',// AND TIME_TO_SEC(TIMEDIFF(NOW(),sessionend))<100',
                                        'params' => array(':param_userlog_id' => $userlog_id),
                                        ),
                    ));
                    $this->render('finishTest', array(
                                                'rightcount'=>$rightanswer_counter,
                                                'questioncount'=>$question_count,
                                                'answerslog'=>$answerslog,
                                                'grade'=>$grade,
                                                'test_id'=>$userlog->test_id,
                                    ));
        
                } 
        }
        
	/**
	 * Manages all models.
	 */
        public function actionPasrequestions($materialID)
        {
            $text = "";
            if (isset($_POST['questions']))
                $text = $_POST['questions'];
            
            $file = fopen('questionsArea.txt', 'w');
            fwrite($file, $text);
            fclose($file);
            $fileR = fopen('questionsArea.txt', 'r');
            $fileWtest = fopen('questionsTest.txt', 'w');
            $fileW = fopen('logparse.txt', 'w');
            $theme = '';
            $qtext = '';
            $atext = array();
            $i = 0;
            $j = 0;
            $flag = 0;
            $rate = 0;
            $testtree_id = $materialID;
            while (!feof($fileR))
            {
                $data = fgets($fileR); 
                $i++;
                
                if (strpos($data,'&0.'))
                {
                    $rate = substr($data, strpos($data,'&0.')+1,3);
                    $data = substr($data, 0, strpos($data,'&0.'));
                }
                
                if (strpos($data,'&1'))
                {
                    $rate = substr($data, strpos($data,'&1')+1,2);
                    $data = substr($data, 0, strpos($data,'&1'));
                }

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
                    echo '<h1>'.$rate.'</h1>';
                    $model->rate = floatval($rate);//rand(1,10)/10;
                    echo '<h1>'.$model->rate .'</h1>';
                    $question_id = 0;
                    if ($model->save())
                    {
                        echo 'Вопрос сохранен!';
                        echo '<br />';
                        $question_id = $model->id;
                    }
                    fwrite($fileWtest, 'themeTitle: '.$theme);
                    fwrite($fileWtest, 'questiontxt: '.$qtext);
                    $testquestionmodel = new Helpquestion;
                    $testquestionmodel->question_id = $question_id;
                    $testquestionmodel->help_id = $testtree_id;
                    if ($testquestionmodel->save())
                    {
                        echo 'Связь вопроса с темой сохранена!';
                        echo '<br />';
                    };
                    echo  $model->theme;
                    echo '<br />';
                    echo $model->text;
                    echo '<br />';
                    echo $model->rate;
                    echo '<br />';
                    
                    $count = 0;
                    foreach ($atext as $answr)
                    {
                        $modelAnswr = new Answer;
                        $count++;
                        fwrite ($fileWtest, 'answer: '.$answr);
                        
                        if (strpos($answr,'+'))
                        {
                            $modelAnswr->isright = 1;
                            $modelAnswr->text = substr($answr,strpos($answr,'+')+1);
                        }
                        else
                        {
                            $modelAnswr->text = substr($answr,2);
                            $modelAnswr->isright = 0;
                        }
                            
                        $modelAnswr->question_id = $question_id;
                        if ($modelAnswr->save())
                        {
                            echo 'Ответ сохранен!';
                            echo '<br />';
                        };
                        
                        echo $modelAnswr->isright.':'.$modelAnswr->text;
                        echo '<br />';
                    }
                    $qtext = '';
                    array_splice($atext, 0);
                }
                if (strpos($data,'$category$')===0)
                {
                    echo $flag.$data;
                    echo '<br />';
                    $theme = substr($data,10);
                    fwrite($fileW, $data);
                    continue;
                }
                $qtext = substr($data,strpos($data,'	'));
                
                
                fwrite($fileW, '::'.$data);
                

            }
            
            {
                    $model = new Question;
                    $model->theme = $theme;
                    $model->text = $qtext;
                    echo '<h1>'.$rate.'</h1>';
                    $model->rate = floatval($rate);//rand(1,10)/10;
                    echo '<h1>'.$model->rate .'</h1>';
                    $question_id = 0;
                    if ($model->save())
                    {
                        echo 'Вопрос сохранен!';
                        echo '<br />';
                        $question_id = $model->id;
                    }
                    fwrite($fileWtest, 'themeTitle: '.$theme);
                    fwrite($fileWtest, 'questiontxt: '.$qtext);
                    $testquestionmodel = new Helpquestion;
                    $testquestionmodel->question_id = $question_id;
                    $testquestionmodel->help_id = $testtree_id;
                    if ($testquestionmodel->save())
                    {
                        echo 'Связь вопроса с темой сохранена!';
                        echo '<br />';
                    };
                    echo  $model->theme;
                    echo '<br />';
                    echo $model->text;
                    echo '<br />';
                    echo $model->rate;
                    echo '<br />';
                    
                    $count = 0;
                    foreach ($atext as $answr)
                    {
                        $modelAnswr = new Answer;
                        $count++;
                        fwrite ($fileWtest, 'answer: '.$answr);
                        
                        if (strpos($answr,'+'))
                        {
                            $modelAnswr->isright = 1;
                            $modelAnswr->text = substr($answr,strpos($answr,'+')+1);
                        }
                        else
                        {
                            $modelAnswr->text = substr($answr,2);
                            $modelAnswr->isright = 0;
                        }
                            
                        $modelAnswr->question_id = $question_id;
                        if ($modelAnswr->save())
                        {
                            echo 'Ответ сохранен!';
                            echo '<br />';
                        };
                        
                        echo $modelAnswr->isright.':'.$modelAnswr->text;
                        echo '<br />';
                    }
                    $qtext = '';
                    array_splice($atext, 0);
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
        public function actionViewResults($id)
        {
            $logs = Userloghelp::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id, 'test_id'=>$id));
            
            $this->render('viewresults', array('logs'=>$logs, 'backurl'=>$_GET['backurl']));
        }

        public function actionAdmin()
	{
		$model=new Helptree('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Helptree']))
			$model->attributes=$_GET['Helptree'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

        public function actionDownloadFile($filename)
        {
            //отключить профайлеры
            //$this->disableProfilers();
            $file1 = fopen('log1123.txt','a');
            $file = $_SERVER['DOCUMENT_ROOT'].'/storage/'.$filename;
            //$file = urlencode(iconv('windows-1251', 'UTF-8',$file));
            fwrite($file1,$file);
            fclose($file1);
            // отдаем файл
            
            //Yii::app()->request->sendFile('log12.txt',file_get_contents($_SERVER['DOCUMENT_ROOT'].'/storage/'.'log12.txt'));

            if (!file_exists($file))
                throw new CHttpException(404,'Файл не найден');
            else
                Yii::app()->request->sendFile(basename($file),file_get_contents($file));
        }       

        public function actionWritetofile()
        {
            $file = fopen('ajaxfile.txt', 'a');
            fwrite($file, '1');
            fclose($file);
        }


        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Helptree::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
                
             
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
        private function actionMakeFolder()
        {
            mkdir($_SERVER['DOCUMENT_ROOT'].'/storage/', 0777);
           /* if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/storage/'))
            {
                mkdir($_SERVER['DOCUMENT_ROOT'].'/storage/', 0777);
            };
            //$file = $_SERVER['DOCUMENT_ROOT'].$model->id.'/images/'.$fileName;

            if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/storage/'.$model->id.'/images/')) 
            {
                $_SERVER['DOCUMENT_ROOT'].'/storage/'.$model->id.'/images/';
            }*/
        }
        
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='addfolder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
