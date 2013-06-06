<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#question-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Банк вопросов</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'question-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'theme',
		'text',
		'image',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<div class="demo_box">
<?php
    if (Yii::app()->user->checkAccess('moderator'))
    {
        /* Диалог добавления раздела */
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogQuestion',
            'options'=>array(
                'title'=>'Вопрос',
                'autoOpen'=>false,
                'modal'=>true,
            ),
        ));
        $questionmodel = new Question;
        //$model->parent_id = $this->model->id;
        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'addQuestion-form',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'form',
                    'accept-charset'=>'UTF-8',
                ),
                //'action' => array('Yii::app()->createUrl("question/createAnswer", array("id"=>$model->id))'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')
                'action' => array('question/create'),
            ));
        ?>

        <?php //добавляем каталог?>
        <?php echo $forms->errorSummary($questionmodel); ?>
        <br />
        <?php echo $forms->labelEx($questionmodel,'text'); ?>
        <br />
        <?php echo $forms->textField($questionmodel,'text',array('maxlength'=>255)); ?>
        <br />
        <?php echo $forms->error($questionmodel,'text'); ?>
        <br />
        <?php echo $forms->labelEx($questionmodel,'theme'); ?>
        <br />
        <?php echo $forms->textField($questionmodel,'theme',array('maxlength'=>255)); ?>
        <br />
        <?php echo $forms->error($questionmodel,'theme'); ?>
        <br />

        <?php echo CHtml::submitButton($questionmodel->isNewRecord ? 'Создать' : 'Сохранить'); ?>

        <?php $this->endWidget();

        $this->endWidget('zii.widgets.jui.CJuiDialog');

       // if (Yii::app()->user->checkAccess('moderator'))
       //     echo CHtml::link('Добавить вопрос', '#', array(
       //         'onclick'=>'$("#dialogQuestion").dialog("open"); return false;',
        //));
        
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonAddFolder',
            'caption'=>'Добавить вопрос',
            //'value'=>'abc',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px; margin-top: 10px; margin-bottom: 10px ',
                'class'=>'ui-button-primary'
                ),
            'onclick'=>'js:function(){$("#dialogQuestion").dialog("open"); return false;}',
            )
        );
    }
        ?>
        
</div>