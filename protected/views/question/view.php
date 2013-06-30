<p>
<?php echo CHtml::link('<< назад(банк вопросов)', Yii::app()->createUrl('question/admin'));?>
</p>
<h3>Просмотр вопроса № <?php echo $model->id; ?></h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'theme',
		'text',
		'image',
                'rate',
	),
)); ?>

<?php
$dataProvider = new CActiveDataProvider('Answer', array(
   'criteria' => array(
      'condition' => 'question_id = :id_q',
      'params' => array(':id_q' => $model->id),
   ),
));
  //  $dataProvider = Answer::model()->findAllByAttributes(array('question_id'=>$model->id));
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'aswer-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$dataProvider,
	'columns'=>array(
		'text',
                array(
                'value' => '$data->isright==0 ? "Не верный" : "Верный"',
                'type' => 'html',
                ),
                'image',
		array(
                    'class'=>'CButtonColumn',
                    'template'=>'{view}{update}{delete}',
                    'viewButtonUrl' => 'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                    'updateButtonUrl' => 'Yii::app()->createUrl("question/updateAnswer", array("id"=>$data->id))',
                    'deleteButtonUrl'=> 'Yii::app()->createUrl("question/deleteAnswer", array("id"=>$data->id))',
                    /*'buttons'=>array
                    (
                        'view' => array
                        (
                            'label'=>'Просмотреть ответ',
                            'url'=>'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                        ),
                        'update' => array
                        (
                            'label'=>'Изменить ответ',
                            'url'=>'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                        ),
                    ),*/

		),
	),
)); ?>

<div class="demo_box">
<?php
    if (Yii::app()->user->checkAccess('moderator'))
    {
        /* Диалог добавления раздела */
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogAnswer',
            'options'=>array(
                'title'=>'Ответ',
                'autoOpen'=>false,
                'modal'=>true,
            ),
        ));
        $answermodel = new Answer;

        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'addanswer-form',
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
                'action' => array('question/createAnswer'),
            ));
        ?>

        <?php echo $forms->errorSummary($answermodel); ?>
        <br />
        <?php echo $forms->labelEx($answermodel,'text'); ?>
        <br />
        <?php echo $forms->textField($answermodel,'text',array('maxlength'=>255)); ?>
        <?php echo $forms->hiddenField($answermodel,'question_id', array('value'=>$model->id)); ?>
        <br />
        <?php echo $forms->error($answermodel,'text'); ?>
        <br />
        <?php echo $forms->dropDownList($answermodel,'isright',
                    array(1=>'Верный', 0=>'Неверный'));
        ?>
        <?php echo CHtml::submitButton($answermodel->isNewRecord ? 'Создать' : 'Сохранить'); ?>

        <?php $this->endWidget();

        $this->endWidget('zii.widgets.jui.CJuiDialog');

       // if (Yii::app()->user->checkAccess('moderator'))
        //    echo CHtml::link('Добавить ответ', '#', array(
        //        'onclick'=>'$("#dialogAnswer").dialog("open"); return false;',
        //));
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonAddFolder',
            'caption'=>'Добавить ответ',
            //'value'=>'abc',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px; margin-top: 10px; margin-bottom: 10px ',
                'class'=>'ui-button-primary'
                ),
            'onclick'=>'js:function(){$("#dialogAnswer").dialog("open"); return false;}',
            )
        );
    }
        ?>
        
</div>