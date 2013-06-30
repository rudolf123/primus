<div id="content">
<p>
<?php echo CHtml::link('<< назад', Yii::app()->createUrl('site/admin'));?>
</p>
<h5>Материалы информационной справки</h5>
<div class="well">
<?php
    $this->renderPartial('adminhelptree', array('modelHelp'=>$modelHelp));
?>
</div>
    
<h5>Материалы обучения</h5>
<div class="well">
<?php
    $this->renderPartial('admintrainingtree', array('modelTrain'=>$modelTrain));
?>
</div>
    
</div>