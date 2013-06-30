<p>
<?php echo CHtml::link('<< назад', Yii::app()->createUrl('testtree/index'));?>
</p>
<?php 
    $this->renderPartial('viewquestions', array('dataProvider'=>$dataProvider, 'model'=>$model));
    $this->renderPartial('viewtestquestions', array('dataProvider'=>$testquestions, 'model'=>$model));
?> 
<h5>Настройки теста</h5>
<div class="well">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'testtree-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
        <div class="row">
        <?php echo $form->dropDownList($model,'parent_id',CHtml::listData(Testtree::model()->findAllByAttributes(
                    array('type'=>0)),'id','title'),
                    array('empty' => 'Без раздела'));
        ?>
        </div>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

        <?php echo $form->hiddenField($model,'etype', array('value'=>1));?>

	<div class="row buttons">
		<?php 
                    $this->widget('zii.widgets.jui.CJuiButton', array(
                                'name'=>'submit',
                                'caption'=>'Сохранить',
                                'htmlOptions'=>array(
                                //'class'=>'btn btn-primary btn-large'
                                ),
                                ));
                ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>