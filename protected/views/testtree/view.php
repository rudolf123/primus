<?php
$this->breadcrumbs=array(
	'Menu Adjacencys'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List MenuAdjacency', 'url'=>array('index')),
	array('label'=>'Create MenuAdjacency', 'url'=>array('create')),
	array('label'=>'Update MenuAdjacency', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MenuAdjacency', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MenuAdjacency', 'url'=>array('admin')),
);
?>
<div id="HelptreeTitle">
<h3><?php echo $model->title; ?></h3>

</div>