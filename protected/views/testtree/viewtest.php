<h4>Информация о тесте</h4>
 

 
<?php// echo CHtml::link('clickMe', Yii::app()->createUrl('testtree/runtest', array('id'=>$model->id)));
?>
<div id="HelptreeViewContent">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
                'time',
                array(               // related city displayed as a link
                    'label'=>'Количество вопросов',
                    'type'=>'raw',
                    'value'=>count($arr_questions),
                    )
	),
)); 
?>
<?php 
    echo Chtml::link('Начать тестирование',Yii::app()->createUrl('testtree/runtest', array('id'=>$model->id)));
?>
<?php 
//echo CHtml::ajaxLink('clickMe3', Yii::app()->createUrl('testtree/viewTest',array('id'=>24)), array('update'=>'#mtreeview-target'));
//echo CHtml::ajaxLink('clickMe', Yii::app()->createUrl('testtree/updateajax'), array('update'=>'#data'));
if (Yii::app()->user->checkAccess('moderator'))
    $this->renderPartial('viewquestions', array('dataProvider'=>$dataProvider, 'model'=>$model));
//else
    //echo CHtml::ajaxButton ("Update data",
                              //Yii::app()->createUrl('testtree/runtest'),array('update' => '#data'));
    
?>

</div>