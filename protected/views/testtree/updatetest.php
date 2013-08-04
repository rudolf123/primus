<?php 
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonBack',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>$backurl,
                )
            );
 ?>
<?php 
    //$this->renderPartial('viewquestions', array('dataProvider'=>$dataProvider, 'model'=>$model));
   // $this->renderPartial('viewtestquestions', array('dataProvider'=>$testquestions, 'model'=>$model));
?> 

<h5>Доступные вопросы</h5>
<div id="ajaxModerateTable" class="well">
<?php

Yii::app()->clientScript->registerScript('ajaxupdate_add', "
$('#question-grid a.ajaxupdate_add').live('click', function() {
        $.fn.yiiGridView.update('question-grid', {
                type: 'POST',
                url: $(this).attr('href'),
                success: function() {
                        $.fn.yiiGridView.update('question-grid');
                        $.fn.yiiGridView.update('testquestion-grid');
                }
        });
        return false;
});
");


Yii::app()->clientScript->registerScript('ajaxupdate_rem', "
$('#testquestion-grid a.ajaxupdate_rem').live('click', function() {
        $.fn.yiiGridView.update('testquestion-grid', {
                type: 'POST',
                url: $(this).attr('href'),
                success: function() {
                        $.fn.yiiGridView.update('testquestion-grid');
                        $.fn.yiiGridView.update('question-grid');
                }
        });
        return false;
});
");


$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'question-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'skin'=>'false',
    'columns'=>array(
            'theme',
            'text',
            'image',
            /*array(
                'class'=>'CButtonColumn',
                'template'=>'{add}',
                'buttons'=>array
                (
                    'add' => array
                    (
                        'label'=>'Добавить в тест',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/assets/plus.png',
                        'url'=>'Yii::app()->createUrl("ajaxupdate", "id"=>'.$model->id.',"qid"=>$data->id), array("class"=>"ajaxupdate"))',
                    ),

                ),
            ),*/
            array(
                'name'=>'',
                'type'=>'raw',
                'value'=>'Chtml::link(CHtml::image("'.Yii::app()->request->baseUrl.'/assets/plus.png","Добавить",array("title"=>"Добавить в тест")),
                                      array("ajaxupdate", "id"=>'.$model->id.',"add_qid"=>$data->id), array("class"=>"ajaxupdate_add"))',  
            ),
    ),
));

?>
</div>

<h5>Вопросы в теме</h5>
<div id="ajaxModerateTableTestQuestions" class="well">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'testquestion-grid',
    'dataProvider'=>$testquestions,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'theme',
            'text',
            'image',
            /*array(
                'class'=>'CButtonColumn',
                'template'=>'{remove}',
                'buttons'=>array
                (
                    'remove' => array
                    (
                        'label'=>'Убрать из теста',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/assets/minus.png',
                        'url'=>'Yii::app()->createUrl("helptree/removequestionfromtest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),
                ),

            ),*/
            array(
                'name'=>'',
                'type'=>'raw',
                'value'=>'Chtml::link(CHtml::image("'.Yii::app()->request->baseUrl.'/assets/minus.png","Убрать",array("title"=>"Убрать из теста")),
                          array("ajaxupdate", "id"=>'.$model->id.',"rem_qid"=>$data->id), array("class"=>"ajaxupdate_rem"))',  
            ),
    ),
));

?>
</div>

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
                                    'class'=>'ui-button-primary'
                                ),
                                ));
                ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>