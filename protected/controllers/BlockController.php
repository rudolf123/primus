<?php

class BlockController extends Controller
{
	public function actionAdmin()
	{
            $model = new Block('search');
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
            $model = Block::model()->findByPk($pk);
            if($model===null)
                throw new CHttpException(400);
            $model->$name = $value;
            if ($model->validate())
                $model->save();
        }  
        
        public function actionCreate()
	{
		$model=new Block;

                if(isset($_POST['Block']))
		{
			$model->attributes=$_POST['Block'];
			if($model->save())
                            $this->redirect(array('admin'));
		}
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function loadModel($id)
	{
		$model=Block::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}