
<?php 
$this->widget('zii.widgets.jui.CJuiButton', array(
    'name'=>'buttonBack',
    'caption'=>'<<< Назад',
    'buttonType'=>'link',
    'url'=>$backurl,
    )
);
 ?>

<h4> Добавление вопросов в тему "<?php echo $model->title?>"</h4>

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
            'id',
            'theme',
            'text',
            'image',
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
            'id',
            'theme',
            'text',
            'image',
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

<div>
<?php 
     /*   $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'loadtformfile-form',
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
                'action' => Yii::app()->createUrl('helptree/pasrequestions', array('materialID'=>$model->id)),

            )); ?>

        <div class="row">
                <?php echo CHtml::textArea('questions'); ?>
        </div>

	<div class="form-actions">
	<?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Загрузить',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px;',
                'class'=>'ui-button-primary'
                ),
            )
        );?>	
            
	</div>

<?php $this->endWidget();*/?> 
</div>
