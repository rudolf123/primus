<?php

class QuestionController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update'),
				'roles'=>array('moderator')
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
                        'backurl'=>$_GET['backurl'],
		));
	}
        
        public function actionViewAnswer($id)
	{
		$this->render('viewAnswer',array(
			'model'=>Answer::model()->findByPk($id),
		));
	}
        
        public function actionDeleteAnswer($id)
	{
		Answer::model()->findByPk($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionCreateAnswer()
	{
		$model=new Answer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Answer']))
		{
			$model->attributes=$_POST['Answer'];
			if($model->save())
                                $this->redirect(array('question/view','id'=>$model->question_id, 'backurl'=>$_GET['backurl']));
		}

		//$this->render('create',array(
		//	'model'=>$model,
		//));
	}
        
        public function actionUpdateAnswer($id)
	{
		$model = Answer::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Answer']))
		{
			$model->attributes=$_POST['Answer'];
			if($model->save())
				$this->redirect($_GET['backurl']);
		}

		$this->render('updateAnswer',array(
			'model'=>$model,
                        'backurl'=>$_GET['backurl'],
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Question;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view', 'id'=>$model->id, 'backurl'=>$_GET['backurl']));
		}

		//$this->render('create',array(
		//	'model'=>$model,
		//));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                
                if (isset($_GET['deletefile']))
                {
                    if ($_GET['deletefile'] === 'img')
                    {
                        @unlink($_SERVER['DOCUMENT_ROOT'].'/storage/questionimgs/'.$model->image);
                        $model->image = '';
                        $model->save();
                    }
                }

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect($_GET['backurl']);
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
                $model = Question::model()->findByPk($id);
                $submodelsAnswers = Answer::model()->findAllByAttributes(array('question_id'=>$id));
                if ($submodelsAnswers)
                    foreach ($submodelsAnswers as $submodel)
                        $submodel->delete();

                Helpquestion::model()->deleteAll(
                    'question_id=:param_question_id',
                    array(
                        ':param_question_id' => $id,
                        ));
                Trainingquestion::model()->deleteAll(
                    'question_id=:param_question_id',
                    array(
                        ':param_question_id' => $id,
                        ));
                Testquestion::model()->deleteAll(
                    'question_id=:param_question_id',
                    array(
                        ':param_question_id' => $id,
                        ));
                                
                $model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Question');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Question('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Question']))
			$model->attributes=$_GET['Question'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Question the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Question::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Question $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
