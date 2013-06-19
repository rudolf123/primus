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
                                    'condition' => 'online = :param_online AND TIME_TO_SEC(TIMEDIFF(NOW(),sessionend))<100',
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
        
}