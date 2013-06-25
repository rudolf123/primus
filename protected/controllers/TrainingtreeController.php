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
        
        public function actionCreate()
	{
		$model=new Trainingtree;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
                
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
                            }
                            $this->redirect('../trainingtree/index');
                        }
                        else
                            $this->redirect('../site/error');
		}
                
                $this->render('create', array('model'=>$model));
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
				$this->redirect('../index');
                        }
		}

		$this->render('update',array(
			'model'=>$model,
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