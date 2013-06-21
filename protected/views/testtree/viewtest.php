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
    echo '</br>';
    if (Yii::app()->user->checkAccess('moderator'))
        echo Chtml::link('Редактировать тест',Yii::app()->createUrl('testtree/updatetest', array('id'=>$model->id)));
?>

</div>