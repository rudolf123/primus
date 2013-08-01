<p>
<?php echo CHtml::link('<< назад', Yii::app()->createUrl('trainingtree/index'));?>
</p>
<h4> Добавление вопросов в тему "<?php echo $model->title?>"</h4>
<?php 
    $this->renderPartial('viewquestions', array('dataProvider'=>$dataProvider, 'model'=>$model));
    $this->renderPartial('viewtestquestions', array('dataProvider'=>$testquestions, 'model'=>$model));
?> 
