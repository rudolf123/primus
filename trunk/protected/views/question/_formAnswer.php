<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'answer-form',
	'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
            'class'=>'well',
            'accept-charset'=>'UTF-8',
        ),
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
                <?php echo $form->labelEx($model,'text'); ?>
                <?php echo $form->textArea($model,'text'); ?>
                <?php echo $form->error($model,'text'); ?>
                <?php echo $form->dropDownList($model,'isright',
                            array(1=>'Верный', 0=>'Неверный'));?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'image'); ?>
		<?php //echo $form->textField($model,'image',array('size'=>50,'maxlength'=>50)); ?>
		<?php //echo $form->error($model,'image'); ?>
	</div>

	<div class="row buttons">
            <?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Сохранить',
            'htmlOptions'=>array(
                'class'=>'ui-button-primary'
                ),
            )
        );?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->