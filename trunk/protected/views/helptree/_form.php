<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'addfolder-form',
                //'type'=>'horizontal',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'well',
                    'enctype'=>'multipart/form-data',
                    'accept-charset'=>'UTF-8',
                ),
                //'action' => array('helptree/update'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

            )); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
                <?php echo Chtml::label('Родительский раздел', 'parent_id'); ?>
                <?php echo $form->dropDownList($model,'parent_id',CHtml::listData(Helptree::model()->findAllByAttributes(
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
                <?php //echo $form->labelEx($model,'htmlfield'); ?>
                <?php echo $form->ckEditorRow($model, 'htmlfield', array('options'=>array('fullpage'=>'js:true', 'width'=>'640', 'resize_maxWidth'=>'640','resize_minWidth'=>'320')));?>
                <?php //echo $form->textArea($model,'htmlfield'); ?>
                <?php echo $form->error($model,'htmlfield'); ?>
	</div>
        <div class="row">
                <?php echo $form->labelEx($model,'img'); ?>
                <?php echo $form->fileField($model,'imgfile'); ?>
                <?php echo $form->error($model,'imgfile'); ?>
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'doc'); ?>
                <?php echo $form->fileField($model,'docfile'); ?>
                <?php echo $form->error($model,'docfile'); ?>
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'pdf'); ?>
                <?php echo $form->fileField($model,'pdffile'); ?>
                <?php echo $form->error($model,'pdffile'); ?>
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'video'); ?>
                <?php echo $form->fileField($model,'videofile'); ?>
                <?php echo $form->error($model,'videofile'); ?>
        </div>
        
        <?php// echo $form->hiddenField($model,'type'); ?>
        <?php //echo $form->hiddenField($model,'icon'); ?>
        <?php// echo $form->hiddenField($model,'url'); ?>
        <?php echo $form->hiddenField($model,'etype', array('value'=>1)); ?>

	<div class="form-actions">
	<?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Сохранить',
            //'value'=>'abc',
            'htmlOptions'=>array(
                'class'=>'ui-button-primary'
                ),
            )
        );?>	
            
        <?php 
            $path = '../index';
            if ($model->isNewRecord)
                $path = 'index';
         
            $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'Cancel',
            'caption'=>'Отмена',
            'htmlOptions'=>array(
                'class'=>'button',
                ),
            'onclick'=>'js:function(){window.location = "'.$path.'"; return false;}',
            )
        );?>	
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->