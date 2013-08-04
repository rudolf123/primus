<div class="content">
<p>
<?php
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonBack',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>Yii::app()->createUrl('site/admin'),
                )
            );
?>
</p>
<h3>Редактирование списка званий</h3>
<?php echo CHtml::link('Список подразделнеий для анкеты', Yii::app()->createUrl('block/admin'));?>
<div class="list_box">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rank-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
                array(
                    'class' => 'bootstrap.widgets.TbEditableColumn',
                    'name' => 'name',
                    'editable' => array(
                        'url' => $this->createUrl('/rank/edit'),
                        'placement' => 'right',
                        'inputclass' => 'span3',
                        'title'=>'Введите значение',
                )),
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{delete}',
                ),
	),
)); ?>

<?php
    if (Yii::app()->user->checkAccess('moderator'))
    {
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogAddRank',
            'options'=>array(
                'title'=>'Новое звание',
                'autoOpen'=>false,
                'modal'=>true,
            ),
        ));
        $rankmodel = new Rank;

        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'addRank-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'form',
                    'accept-charset'=>'UTF-8',
                ),
                'action' => array('rank/create'),
            ));
        ?>

        <?php //добавляем каталог?>
        <?php echo $forms->errorSummary($rankmodel); ?>
        <br />
        <?php echo $forms->labelEx($rankmodel,'name'); ?>
        <br />
        <?php echo $forms->textField($rankmodel,'name',array('maxlength'=>255)); ?>
        <br />
        <?php echo $forms->error($rankmodel,'name'); ?>
        <br />

        <?php echo CHtml::submitButton($rankmodel->isNewRecord ? 'Создать' : 'Сохранить'); ?>

        <?php $this->endWidget();

        $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>
<div class="button_box">
        <?php
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonAddRank',
            'caption'=>'Добавить звание',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px;',
                'class'=>'ui-button-primary'
                ),
            'onclick'=>'js:function(){$("#dialogAddRank").dialog("open"); return false;}',
            )
        );
    }
        ?>
        
</div>
</div>