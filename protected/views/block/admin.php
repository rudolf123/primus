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
<h3>Редактирование списка подразделений</h3>
<?php echo CHtml::link('Список званий для анкеты', Yii::app()->createUrl('rank/admin'));?>
<div class="list_box">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'block-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
                array(
                    'class' => 'bootstrap.widgets.TbEditableColumn',
                    'name' => 'name',
                    'editable' => array(
                        'url' => $this->createUrl('/block/edit'),
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
</div>

<?php
    if (Yii::app()->user->checkAccess('moderator'))
    {
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogAddBlock',
            'options'=>array(
                'title'=>'Новое подразделение',
                'autoOpen'=>false,
                'modal'=>true,
            ),
        ));
        $blockmodel = new Block;

        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'addBlock-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'form',
                    'accept-charset'=>'UTF-8',
                ),
                'action' => array('block/create'),
            ));
        ?>

        <?php //добавляем каталог?>
        <?php echo $forms->errorSummary($blockmodel); ?>
        <br />
        <?php echo $forms->labelEx($blockmodel,'name'); ?>
        <br />
        <?php echo $forms->textField($blockmodel,'name',array('maxlength'=>100)); ?>
        <br />
        <?php echo $forms->error($blockmodel,'name'); ?>
        <br />

        <?php echo CHtml::submitButton($blockmodel->isNewRecord ? 'Создать' : 'Сохранить'); ?>

        <?php $this->endWidget();

        $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>
<div class="button_box">
        <?php
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonAddBlock',
            'caption'=>'Добавить подразделение',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px;',
                'class'=>'ui-button-primary'
                ),
            'onclick'=>'js:function(){$("#dialogAddBlock").dialog("open"); return false;}',
            )
        );
    }
        ?>
        
</div>
</div>