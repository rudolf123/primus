<?php 
//echo CHtml::ajaxLink('clickMe3', Yii::app()->createUrl('testtree/viewTest',array('id'=>24)), array('update'=>'#mtreeview-target'));
//echo CHtml::ajaxLink('clickMe', Yii::app()->createUrl('testtree/updateajax'), array('update'=>'#data'));
//if (Yii::app()->user->checkAccess('moderator'))
    $this->renderPartial('viewquestions', array('dataProvider'=>$dataProvider, 'model'=>$model));
//else
    //echo CHtml::ajaxButton ("Update data",
                              //Yii::app()->createUrl('testtree/runtest'),array('update' => '#data'));
    
?>
