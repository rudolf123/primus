<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
            ),
        'htmlOptions'=>array(
            'class'=>'well',
            'enctype'=>'multipart/form-data',
            'accept-charset'=>'UTF-8',
        ),
        'action'=>array('question/update', 'id'=>$model->id, 'backurl'=>$backurl),
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'theme'); ?>
		<?php echo $form->textField($model,'theme',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'theme'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
                <?php echo $form->labelEx($model,'image'); ?>
                <?php echo $form->fileField($model,'imgfile'); ?>
                <?php echo $form->error($model,'imgfile'); ?>
            
                <?php
                if ($model->image != '')
                {
                            echo CHtml::image('/storage/questionimgs/'.$model->image,'Изображение недоступно!', array('style'=>"width: 40px; height: 40px"));
                            echo Chtml::link(CHtml::image('/assets/delete.png','delete icon is missing',array('title'=>'Удалить файл')), Yii::app()->createUrl('question/update', array('id'=>$model->id, 'deletefile'=>'img','backurl'=>$backurl)),array('confirm'=>'Вы действительно хотите удалить файл?'));
                }
                ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'rate'); ?>
		<?php echo $form->textField($model,'rate'); ?>
		<?php echo $form->error($model,'rate'); ?>
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