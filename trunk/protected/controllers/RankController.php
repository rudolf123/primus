<?php

class RankController extends Controller
{
	public function actionAdmin()
	{
            $model = new Rank('search');
            $model->unsetAttributes();  // clear any default values
            $this->render('admin',array(
                    'model'=>$model,
            ));
	}
        
        public function actionEdit() 
        {
            $pk = Yii::app()->request->getPost('pk');
            $name = Yii::app()->request->getPost('name');
            $value = Yii::app()->request->getPost('value');
            $model = Rank::model()->findByPk($pk);
            if($model===null)
                throw new CHttpException(400);
            $model->$name = $value;
            if ($model->validate())
                $model->save();
        }  
        
        public function actionCreate()
	{
		$model=new Rank;

                if(isset($_POST['Rank']))
		{
			$model->attributes=$_POST['Rank'];
			if($model->save())
                            $this->redirect(array('admin'));
		}
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function loadModel($id)
	{
		$model=Rank::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}