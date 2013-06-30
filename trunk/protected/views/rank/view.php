<?php
$this->breadcrumbs=array(
	'Ranks'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Rank', 'url'=>array('index')),
	array('label'=>'Create Rank', 'url'=>array('create')),
	array('label'=>'Update Rank', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Rank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Rank', 'url'=>array('admin')),
);
?>

<h1>View Rank #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
