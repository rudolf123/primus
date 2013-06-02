<h1>Просмотр теста <?php echo $model->title; ?></h1>
 

 
<?php echo CHtml::link('clickMe', Yii::app()->createUrl('testtree/runtest', array('id'=>$model->id)));
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
	),
)); 
?>



<?php //echo CHtml::ajaxLink('clickMe', Yii::app()->createUrl('testtree/updateajax'), array('update'=>'#Ajaxdata'));

$this->renderPartial('viewquestions', array('dataProvider'=>$dataProvider, 'model'=>$model));
?>

