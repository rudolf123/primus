<h1>Просмотр ответа №<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'isright',
		'text',
		'image',
	),
)); ?>