<?php

class TesttreeController extends Controller
{
        	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array('index','view','downloadfile','updateajax'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete'),
				'roles'=>array('Moderator')
			),
		);
	}
        public function actionAddQuestionToTest($question_id,$test_id)
        {
            $testquestion = new Testquestion;
            $testquestion->test_id = $test_id;
            $testquestion->question_id = $question_id;
            $testquestion->save();
            $testquestions = Testquestion::model()->findAllByAttributes(array('test_id'=>$test_id));
            $count_questions = count($testquestions);
            if($count_questions > 0){
                $arr_questions = array();
                foreach($testquestions as $testquestion)
                    array_push($arr_questions,$testquestion->question_id);
            }
            $criteria = new CDbCriteria();
            $criteria->addNotInCondition('id', $arr_questions);

            $dataProvider = new CActiveDataProvider('Question', array(
               'criteria' => $criteria));

            $model = $this->loadModel($test_id);

            $this->render('updatetest',array(
                        'model'=>$model,
                        'dataProvider'=>$dataProvider,
                        ),false,true);
            //$this->redirect('../testtree/index/viewtest', array('id'=>$testquestion->test_id));
            //if($testquestion->save())
           // {
           //     $this->redirect('../testtree/index');
           // }
           // else
            //    $this->redirect('../site/error');
            
        }
        
        public function actionRemoveQuestionFromTest($question_id,$test_id)
        {
            $testquestion = new Testquestion;
            $testquestion->test_id = $test_id;
            $testquestion->question_id = $question_id;
            $testquestion->save();
            $testquestions = Testquestion::model()->findAllByAttributes(array('test_id'=>$test_id));
            $count_questions = count($testquestions);
            if($count_questions > 0){
                $arr_questions = array();
                foreach($testquestions as $testquestion)
                    array_push($arr_questions,$testquestion->question_id);
            }
            $criteria = new CDbCriteria();
            $criteria->addNotInCondition('id', $arr_questions);

            $dataProvider = new CActiveDataProvider('Question', array(
               'criteria' => $criteria));

            $model = $this->loadModel($test_id);

            $this->renderPartial('_viewquestions',array(
                    'dataProvider'=>$dataProvider,
                    ));
        }
        
        public function actionAjax($userlog_id)
        {
                if(isset($_POST['QuestionForm']))
                {
                    $file = fopen('logTestAjax.txt', 'a');
                    fwrite($file,'ID лога:  '.$userlog_id);
                    fwrite($file,'ID теста: '.$_POST['QuestionForm']['test_id']);
                    $rightanswwer_counter = 0;
                    

                    $userlog = Userlog::model()->findByPk($userlog_id);
                    $userlog->endtime = date('Y-m-d H:i:s', time());
                    
                    $rightanswwer_counter = 0;

                    //$this->render('finishTest', array('rightcount'=>$rightanswwer_counter,'questioncount'=>$question_count, 'answerslog'=>$answerslog));
                    fwrite($file,'Вопросы с одним вариантом ответа:  ');
                    if(isset($_POST['QuestionForm']['answers']))
                        foreach ($_POST['QuestionForm']['answers'] as $attr)
                        {
                            list($question_id, $answer_id) = explode(";", $attr);
                            
                            $checkanswer = Answer::model()->findByAttributes(array('question_id'=>$question_id,'id'=>$answer_id));
                            if ($checkanswer->isright)
                                $rightanswwer_counter++;
                            $userloganswers = new Userloganswers;
                            $userloganswers->answer_id = $answer_id;
                            $userloganswers->answer_text = $checkanswer->text;
                            $userloganswers->question_text = Question::model()->findByPk($question_id)->text;;
                            $userloganswers->question_id = $question_id;
                            $userloganswers->userlog_id = $userlog_id;
                            $userloganswers->isright = $checkanswer->isright;
                            $userloganswers->save();
                            
                            fwrite($file, 'question_ = '.$userloganswers->question_text.':answer_ = '.$checkanswer->text.';');
                        }
                    /*fwrite($file,'Вопросы с несколькими вариантами ответа:  ');
                    if(isset($_POST['QuestionForm']['answersmulti']))
                    {
                        $countofright = array();
                        foreach ($_POST['QuestionForm']['answersmulti'] as $attr)
                        {
                            
                            list($question_id, $answer_id) = explode(";", $attr);
                            fwrite($file, 'question_id = '.$question_id.':answer_id = '.$answer_id.';');
                            $rightanswers = Answer::model()->findAllByAttributes(array('question_id'=>$question_id,'isright'=>1));
                            foreach ($rightanswers as $a)
                                if ($answer_id==$a->id)
                                    $countofright[]=
                        }
                    }*/
                    fwrite($file, 'Количество правильных ответов: '.$rightanswwer_counter);
                    $question_count = count(Testquestion::model()->findAllByAttributes(array('test_id'=>$_POST['QuestionForm']['test_id'])));
                    $userlog->save();
                    $answerslog = new CActiveDataProvider('Userloganswers', array(
                                        'criteria' => array(
                                        'condition' => 'userlog_id = :param_userlog_id',// AND TIME_TO_SEC(TIMEDIFF(NOW(),sessionend))<100',
                                        'params' => array(':param_userlog_id' => $userlog_id),
                                        ),
                    ));
                    fwrite($file, 'Количество вопросов: '.$question_count);
                    fclose($file);
                    
                    //$this->redirect('../testtree/finishTest',array('rightcount'=>$rightanswwer_counter,'questioncount'=>$question_count, 'answerslog'=>$answerslog));
                    $this->render('finishTest', array('rightcount'=>$rightanswwer_counter,'questioncount'=>$question_count, 'answerslog'=>$answerslog));
        
                } 
        }


        public function actionUpdateTest($id)
        {
                $testquestions = Testquestion::model()->findAllByAttributes(array('test_id'=>$id));
                $count_questions = count($testquestions);
                if($count_questions > 0){
                    $arr_questions = array();
                    foreach($testquestions as $testquestion)
                        array_push($arr_questions,$testquestion->question_id);
                }
                $criteria = new CDbCriteria();
                $questionsintest = new CActiveDataProvider('Question', array(
                   'criteria' => $criteria));
                $criteria->addNotInCondition('id', $arr_questions);

                $dataProvider = new CActiveDataProvider('Question', array(
                   'criteria' => $criteria));

                $model = $this->loadModel($id);


                $this->render('updatetest',array(
                        'model'=>$model,
                        'dataProvider'=>$dataProvider,
                        'testquestions'=>$questionsintest,
                        ),false,true);
        }
        
        public function actionViewTest($id)
	{
            $testquestions = Testquestion::model()->findAllByAttributes(array('test_id'=>$id));
            $count_questions = count($testquestions);
            if($count_questions > 0){
                $arr_questions_ids = array();
                foreach($testquestions as $testquestion)
                    array_push($arr_questions_ids,$testquestion->question_id);
            }
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $arr_questions_ids);

            $questions = Question::model()->findAll($criteria);
            $arr_questions = array();
            $arr_answers = array();
            foreach($questions as $question)
            {
                $arr_answers_ = array();
                array_push($arr_questions,$question->text);
                $answers = Answer::model()->findAllByAttributes(array('question_id'=>$question->id));
                foreach($answers as $answer)
                {
                    array_push($arr_answers_,$answer->text);
                }
                array_push($arr_answers, $arr_answers_);
            }
            $model = $this->loadModel($id);
            $qmodel = new QuestionForm;
            $userlogcount = count(Userlog::model()->findAllByAttributes(array('test_id'=>$id, 'user_id'=>Yii::app()->user->id)));
            $this->renderPartial('viewtest',array(
                    'arr_answers'=>$arr_answers,
                    'arr_questions'=>$arr_questions,
                    'qmodel'=>$qmodel,
                    'model'=>$model,
                    'userlogcount'=>$userlogcount,
                    ),false,true);

        }
        
        public function actionView($id)
	{
                $model = $this->loadModel($id);
               // if ($model->test_id!=null)
              //  {
              //      $questions=Testquestion::model()->findAllByAttributes(array('test_id'=>$model->test_id)); // $params is not needed
              //  }
                //$test=Test::model()->findByPk($model->test_id); // $params is not needed
		
                $this->renderPartial('view',array(
			'model'=>$model,
			),false,true);
		/*if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial('view',array(
				'model'=>$this->loadModel($id),
			),false,true);
		else
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));*/
	}
        
        public function actionCreate()
	{
		$model=new Testtree;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
                
		if(isset($_POST['Testtree']))
		{
                    //$file1 = fopen('log1678.txt','a');
			$model->attributes=$_POST['Testtree'];
 
                        $model->type=$_POST['Testtree']['etype'];
                       // $model->htmlfield = $_POST['Testtree']['htmlfield'];
 
                     //   fwrite($file1,'ActionCreate');
                     //   fclose($file1);
                        if ($model->type==0)
                        {
                            $model->icon='folder_key.png';
                        }
                        if ($model->type==1)
                        {
                            $model->icon='table.png';
                            //$model->url = Yii::app()->createUrl("question/view", array("id"=>$model->id));
                        }
                        if($model->save())
                        {
                            if ($model->type==1)
                            {
                                $model->url = '/testtree/viewTest/'.$model->id;
                                $model->save();
                            }
                            $this->redirect('../testtree/index');
                        }
                        else
                            $this->redirect('../site/error');
		}
	}
        
	public function actionIndex()
	{
                $data = "Content loaded";

                if(Yii::app()->user->checkAccess('user'))
                {
                    $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                    $model->section = 'Проверяет знания';
                    $model->save();
                }
                
		$dataProvider=new CActiveDataProvider('Testtree');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
                        'myValue'=>$data,
		));
	}
        
        public function actionUpdateAjax()
        {
            
            /*$data = array();
            $data["myValue"] = "Content updated in AJAX";
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            if(Yii::app()->request->isAjaxRequest){
                    echo CHtml::encode('$output');
                    $this->renderPartial('viewtest', $data, false, false);
            }*/

        }
        
        
        public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
        
        public function actionRunTest($id)
        {
            $testquestions = Testquestion::model()->findAllByAttributes(array('test_id'=>$id));
            $testtreemodel = Testtree::model()->findByPk($id);
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

            $userlogcount = count(Userlog::model()->findByAttributes(array('test_id'=>$id, 'user_id'=>Yii::app()->user->id)));
           // if (count($userlogcount)==0)
            
            $userlog = new Userlog;            
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
        
        public function actionFinishtest($userlog_id)
        {
                if(isset($_POST['QuestionForm']))
                {
                    $userlog = Userlog::model()->findByPk($userlog_id);
                    $userlog->endtime = date('Y-m-d H:i:s', time());
                    
                    $rightanswwer_counter = 0;
                    if(isset($_POST['QuestionForm']['answers']))
                        foreach ($_POST['QuestionForm']['answers'] as $attr)
                        {
                            list($question_id, $answer_id) = explode(";", $attr);

                            $checkanswer = Answer::model()->findByAttributes(array('question_id'=>$question_id,'id'=>$answer_id));
                            if ($checkanswer->isright)
                                $rightanswwer_counter++;
                            $userloganswers = new Userloganswers;
                            $userloganswers->answer_id = $answer_id;
                            $userloganswers->answer_text = $checkanswer->text;
                            $userloganswers->question_text = Question::model()->findByPk($question_id)->text;;
                            $userloganswers->question_id = $question_id;
                            $userloganswers->userlog_id = $userlog_id;
                            $userloganswers->isright = $checkanswer->isright;
                            $userloganswers->save();
                        }
                    $answerslog = Userloganswers::model()->findAllByAttributes(array('userlog_id'=>$userlog_id));
                    $question_count = count(Testquestion::model()->findAllByAttributes(array('test_id'=>$_POST['QuestionForm']['test_id'])));

                    $this->render('finishTest', array('rightcount'=>$rightanswwer_counter,'questioncount'=>$question_count, 'answerslog'=>$answerslog));
        
                } 
        }

        public function loadModel($id)
	{
		$model = Testtree::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
                
		return $model;
	}
        
        protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='addtesttree-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}