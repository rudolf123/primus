<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        public function actionKeepAliveStatus($val1, $val2) 
        {
            if (!Yii::app()->user->isGuest)
            {
                $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                $res = (strtotime(date('Y-m-d H:i:s', time())) - strtotime($model->sessionend));// strtotime($model->sessionstart));
                $model->sessionend = date('Y-m-d H:i:s', time());
                $model->learningtime = $model->learningtime + $res;
                $model->save();
            }
            
            /*$file = fopen('ajaxlog.txt', 'a');
            fwrite($file, $val1);
            fwrite($file, '; ');
            fwrite($file, $val2);
            fwrite($file, '; ');
            fclose($file);*/
            /*User::model()->updateByPk( 
                Yii::app()->user->id, 
               // array('t_last_activity' => 'NOW()') //CURRENT_TIMESTAMP
             array('t_last_activity' => new CDbExpression('NOW()')) //CURRENT_TIMESTAMP..this working fine 
                );*/
        }
        
        public function keepAliveAction() 
        {
            if (!Yii::app()->user->isGuest)
            {
                $model = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                $res = (strtotime(date('Y-m-d H:i:s', time())) - strtotime($model->sessionend));// strtotime($model->sessionstart));
                $model->sessionend = date('Y-m-d H:i:s', time());
                $model->learningtime = $model->learningtime + $res;
                $model->save();
            }
            /*User::model()->updateByPk( 
                Yii::app()->user->id, 
               // array('t_last_activity' => 'NOW()') //CURRENT_TIMESTAMP
             array('t_last_activity' => new CDbExpression('NOW()')) //CURRENT_TIMESTAMP..this working fine 
                );*/
        }

        // Runs after any action in controller
        public function afterAction($action) 
        {
            self::keepAliveAction();
            parent::afterAction($action);
        }

        // This action can be reached by ajax every 5min 
        // if user stays in one page long enaugh
        // (write javascript..)
        public function actionImAlive() 
        {
            self::keepAliveAction();
        }
}