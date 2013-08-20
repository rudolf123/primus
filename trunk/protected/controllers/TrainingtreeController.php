<?php

class TrainingtreeController extends Controller
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
        
        public function actionView($id)
	{
		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial('view',array(
				'model'=>$this->loadModel($id),
			),false,true);
		else
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
	}
        
        public function actionDelete($id)
	{
            $this->loadModel($id)->delete();
            $this->redirect('../index');
        }
        
        public function actionCreate()
	{
		$model=new Trainingtree;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
                
		if(isset($_POST['Trainingtree']))
		{
                    //$file1 = fopen('log1678.txt','a');
			$model->attributes=$_POST['Trainingtree'];
 
                        $model->type=$_POST['Trainingtree']['etype'];
                        $model->htmlfield = $_POST['Trainingtree']['htmlfield'];
 
                     //   fwrite($file1,'ActionCreate');
                     //   fclose($file1);
                        if ($model->type==0)
                            $model->icon='folder_key.png';
                        if ($model->type==1)
                            $model->icon='table.png';
                        if($model->save())
                        {
                            if ($model->type==1)
                            {
                                $model->url = '/trainingtree/view/'.$model->id;
                                $model->save();
                                $this->redirect('../'.$model->url);
                            }
                            if ($model->type==0)
                            {
                                if (isset($_GET['backurl']))
                                    $this->redirect($_GET['backurl']);
                                else 
                                    $this->redirect('../helptree/index');
                            }
                            $this->redirect('../trainingtree/index');
                        }
		}
                
                $this->render('create', array('model'=>$model, 'backurl'=>$_GET['backurl']));
	}
        
        public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Trainingtree']))
		{
			$model->attributes=$_POST['Trainingtree'];
                        $model->htmlfield = $_POST['Trainingtree']['htmlfield'];

			if($model->save())
                        {
				$this->redirect('../view/'.$model->id);
                        }
		}

		$this->render('update',array(
			'model'=>$model,
                        'backurl'=>$_GET['backurl']
		));
	}
        
	public function actionIndex()
	{
                if(Yii::app()->user->checkAccess('user'))
                {
                    $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                    $model->section = 'Проходит обучение';
                    $model->save();
                }
                        
		$dataProvider=new CActiveDataProvider('Trainingtree');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
        
        public function actionAjaxUpdate($id)
        {
            if (isset($_GET['add_qid']))
            {
                $testquestion = new Trainingquestion;
                $testquestion->training_id = $id;
                $testquestion->question_id = $_GET['add_qid'];
                $testquestion->save();

                $testquestions = Trainingquestion::model()->findAllByAttributes(array('training_id'=>$id));
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
                Trainingquestion::model()->deleteAll(
                                    'training_id = :param_test_id AND question_id=:param_question_id',
                                    array(
                                        ':param_test_id' => $id,
                                        ':param_question_id' => $_GET['rem_qid'],
                                        ));
            
                $testquestions = Trainingquestion::model()->findAllByAttributes(array('training_id'=>$id));
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
               
                $testquestions = Trainingquestion::model()->findAllByAttributes(array('training_id'=>$id));
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
            $testquestions = Trainingquestion::model()->findAllByAttributes(array('training_id'=>$id));
            $testtreemodel = Trainingtree::model()->findByPk($id);
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

            $userlogcount = count(Userlogtraining::model()->findByAttributes(array('test_id'=>$id, 'user_id'=>Yii::app()->user->id)));
           // if (count($userlogcount)==0)
            
            $userlog = new Userlogtraining;            
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
                    $userlog = Userlogtraining::model()->findByPk($userlog_id);
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
                            $userloganswers = new Userloganswerstraining;
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

                    $question_count = count(Trainingquestion::model()->findAllByAttributes(array('training_id'=>$_POST['QuestionForm']['test_id'])));
                    $grade /= $question_count;
                    $userlog->grade = round($grade,2);
                    $userlog->save();
                    $answerslog = new CActiveDataProvider('Userloganswerstraining', array(
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
        
        public function actionViewResults($id)
        {
            $logs = Userlogtraining::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id, 'test_id'=>$id));
            
            $this->render('viewresults', array('logs'=>$logs, 'backurl'=>$_GET['backurl']));
        }
        
        public function actionDownloadFile($filename)
        {
            //отключить профайлеры
            //$this->disableProfilers();
            $file1 = fopen('log1123.txt','a');
            $file = $_SERVER['DOCUMENT_ROOT'].'/storage/training/'.$filename;
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

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=  Trainingtree::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
                
                $this->treenodeid = $model->id;
                
		return $model;
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