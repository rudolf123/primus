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
                //'action' => array('helptree/create'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

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
                <?php echo $form->ckEditorRow($model, 'htmlfield', array('options'=>array('fullpage'=>'js:true', 'width'=>'840','height'=>'640', 'resize_maxWidth'=>'1040','resize_minWidth'=>'320')));?>
                <?php //echo $form->textArea($model,'htmlfield'); ?>
                <?php echo $form->error($model,'htmlfield'); ?>
	</div>
        <div class="row">
                <?php echo $form->labelEx($model,'img'); ?>
                <?php echo $form->fileField($model,'imgfile'); ?>
                <?php echo $form->error($model,'imgfile'); ?>
                <?php 
                if ($model->img != '')
                {
                            echo CHtml::image('/storage/'.$model->img,'Picture is missing', array('style'=>"width: 40px; height: 40px"));
                            echo Chtml::link(CHtml::image('/assets/delete.png','delete icon is missing',array('title'=>'Удалить файл')), Yii::app()->createUrl('helptree/update', array('id'=>$model->id, 'deletefile'=>'img','backurl'=>$backurl)),array('confirm'=>'Вы действительно хотите удалить файл?'));
                            /*$this->widget('bootstrap.widgets.TbButton', array(
                                'label'=>'Удалить',
                                'type'=>'danger',
                                'htmlOptions'=>array(
                                            'onclick'=>'js:bootbox.confirm("Вы уверены?",
                                            function(confirmed)
                                            {
                                                deletefile(confirmed)
                                            }
                                            )'
                                ),
                            ));*/
                }
                ?>
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'doc'); ?>
                <?php echo $form->fileField($model,'docfile'); ?>
                <?php echo $form->error($model,'docfile'); ?>
                <?php if ($model->doc != '')
                      {
                            echo Chtml::link(CHtml::image('/assets/doc.gif','doc icon is missing',array('width'=>'40px','height'=>'40px')),Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>$model->doc)));
                            
                            //echo Chtml::link(CHtml::image('/assets/delete.png','delete icon is missing',array('title'=>'Удалить файл')), '#',array('submit'=>array('helptree/update',array('id'=>$model->id, 'deletefile'=>'doc', 'backurl'=>$backurl)),'confirm'=>'Вы действительно хотите удалить материал?'));        
                            echo Chtml::link(CHtml::image('/assets/delete.png','delete icon is missing',array('title'=>'Удалить файл')), Yii::app()->createUrl('helptree/update', array('id'=>$model->id, 'deletefile'=>'doc','backurl'=>$backurl)),array('confirm'=>'Вы действительно хотите удалить файл?'));
                      }
                ?>
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'pdf'); ?>
                <?php echo $form->fileField($model,'pdffile'); ?>
                <?php echo $form->error($model,'pdffile'); ?>
                <?php if ($model->pdf != '')
                {
                            echo Chtml::link(CHtml::image('/assets/pdf.gif','doc icon is missing',array('width'=>'40px','height'=>'40px')),Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>$model->pdf)));
                            echo Chtml::link(CHtml::image('/assets/delete.png','delete icon is missing',array('title'=>'Удалить файл')), Yii::app()->createUrl('helptree/update', array('id'=>$model->id, 'deletefile'=>'pdf','backurl'=>$backurl)),array('confirm'=>'Вы действительно хотите удалить файл?'));
                }
                ?>
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'video'); ?>
                <?php echo $form->fileField($model,'videofile'); ?>
                <?php echo $form->error($model,'videofile'); ?>
                <?php if ($model->video != '')
                {
                            //echo Chtml::link(CHtml::image('/assets/pdf.gif','doc icon is missing',array('width'=>'40px','height'=>'40px')),Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>$model->pdf)));
                            echo Chtml::link(CHtml::image('/assets/delete.png','delete icon is missing',array('title'=>'Удалить файл')), Yii::app()->createUrl('helptree/update', array('id'=>$model->id, 'deletefile'=>'video','backurl'=>$backurl)),array('confirm'=>'Вы действительно хотите удалить файл?'));
                }
                ?>
        </div>
        
        <?php echo $form->hiddenField($model,'etype', array('value'=>1)); ?>

	<div class="form-actions">
	<?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Сохранить',
            //'value'=>'abc',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px;',
                'class'=>'ui-button-primary'
                ),
            )
        );?>	
            
	</div>

<?php $this->endWidget(); ?>


</div><!-- form -->

<script>

            function deletefile(name)
            { 
                var name1 = 'sdfsdf';
                    $.ajax({
                        type: "POST",
                        url:  "<?php echo Yii::app()->createUrl('helptree/Ajaxdeletepic',array('name'=>name)); ?>" + name,
                        data:  {},
                        success: function(){
                            // alert("Sucess");
                            },
                        error: function(){
                       // alert("failure");

                        }
                      });
            }
            //setInterval(timer,5000);

</script>

<!--<script type="text/javascript">
        AjexFileManager.init({
        returnTo: 'function',
        skin: 'light'
        });
        function insertValue(filePath) {
        document.getElementById('srcFile_function').value = filePath;
        return;
        }
</script>-->