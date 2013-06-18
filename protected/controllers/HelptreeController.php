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
                                $this->redirect('../helptree/index');
                            }
                        }
		}
               
                $this->render('create',array(
                        'model'=>$model,
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
                            $this->redirect('../helptree/index');
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
		if(isset($_POST['Helptree']))
		{
			$model->attributes=$_POST['Helptree'];
                        $model->htmlfield = $_POST['Helptree']['htmlfield'];

			if($model->save())
                        {
				$this->redirect('../index');
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			//if(!isset($_GET['ajax']))
			//	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		//else
		//	throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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

	/**
	 * Manages all models.
	 */
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
