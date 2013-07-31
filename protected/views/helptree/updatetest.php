<p>
<?php echo CHtml::link('<< назад', Yii::app()->createUrl('helptree/index'));?>
</p>
<?php 
    $this->renderPartial('viewquestions', array('dataProvider'=>$dataProvider, 'model'=>$model));
    $this->renderPartial('viewtestquestions', array('dataProvider'=>$testquestions, 'model'=>$model));
?> 
