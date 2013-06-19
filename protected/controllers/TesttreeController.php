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

            $this->renderPartial('_viewquestions',array(
                    'dataProvider'=>$dataProvider,
                    ));
            //$this->redirect('../testtree/index/viewtest', array('id'=>$testquestion->test_id));
            //if($testquestion->save())
           // {
           //     $this->redirect('../testtree/index');
           // }
           // else
            //    $this->redirect('../site/error');
            
        }
        public function actionAjax()
        {
                if(isset($_POST['QuestionForm']))
                {
                    $file = fopen('logTestAjax.txt', 'a');
                    $rightanswwer_counter = 0;
                    fwrite($file,'Вопросы с одним вариантом ответа:  ');
                    if(isset($_POST['QuestionForm']['answers']))
                        foreach ($_POST['QuestionForm']['answers'] as $attr)
                        {
                            list($question_id, $answer_id) = explode(";", $attr);
                            fwrite($file, 'question_id = '.$question_id.':answer_id = '.$answer_id.';');
                            $checkanswer = Answer::model()->findByAttributes(array('question_id'=>$question_id,'id'=>$answer_id));
                            if ($checkanswer->isright)
                                $rightanswwer_counter++;
                        }
                    fwrite($file,'Вопросы с несколькими вариантами ответа:  ');
                    if(isset($_POST['QuestionForm']['answersmulti']))
                    {
                        /*$countofright = array();
                        foreach ($_POST['QuestionForm']['answersmulti'] as $attr)
                        {
                            
                            list($question_id, $answer_id) = explode(";", $attr);
                            fwrite($file, 'question_id = '.$question_id.':answer_id = '.$answer_id.';');
                            $rightanswers = Answer::model()->findAllByAttributes(array('question_id'=>$question_id,'isright'=>1));
                            foreach ($rightanswers as $a)
                                if ($answer_id==$a->id)
                                    $countofright[]=
                        }*/
                    }
                    fwrite($file, 'Количество правильных ответов: '.$rightanswwer_counter);
                    fclose($file);
                } 
        }


        public function actionViewTest($id)
	{
            if (Yii::app()->user->checkAccess('moderator'))
            {
                $testquestions = Testquestion::model()->findAllByAttributes(array('test_id'=>$id));
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

                $model = $this->loadModel($id);


                $this->renderPartial('viewtest',array(
                        'model'=>$model,
                        'dataProvider'=>$dataProvider,
                        ),false,true);
            }
            else 
            {

                //$file = fopen('logTest.txt', 'a');
                //fwrite($file, 'logBegin');
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
                    //fwrite($file, $question->text);
                    $answers = Answer::model()->findAllByAttributes(array('question_id'=>$question->id));
                    foreach($answers as $answer)
                    {
                        array_push($arr_answers_,$answer->text);
                        //fwrite($file, $answer->text);
                    }
                    array_push($arr_answers, $arr_answers_);
                }
                //fwrite($file, 'logEnd');
                //fclose($file);
                $model = $this->loadModel($id);
                $qmodel = new QuestionForm;
                $this->renderPartial('viewtest',array(
                        'arr_answers'=>$arr_answers,
                        'arr_questions'=>$arr_questions,
                        'qmodel'=>$qmodel,
                        'model'=>$model,
                        ),false,true);

            }
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


            $this->render('runtest', array(
                        'questions'=>$questions,
                        'model'=>$qmodel,
                        'test_id'=>$id,
                        ), false, true);
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