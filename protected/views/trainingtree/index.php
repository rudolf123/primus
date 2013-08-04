<h4>Обучение</h4>
<div id="leftcolumn">
    <div id="mtreeview">
    <?php
            $this->widget('application.extensions.MTreeView.MTreeView',array(
                    'collapsed'=>true,
                    'animated'=>'fast',
                    //---MTreeView options from here
                    'table'=>'tbl_trainingtree',//what table the menu would come from
                    'hierModel'=>'adjacency',//hierarchy model of the table
                    //'conditions'=>array('visible=:visible',array(':visible'=>1)),//other conditions if any                                    
                    'fields'=>array(//declaration of fields
                            'text'=>'title',//no `text` column, use `title` instead
                            'alt'=>'title',//skip using `alt` column
                            'id_parent'=>'parent_id',//no `id_parent` column,use `parent_id` instead
                            'position'=>'type',
                            'task'=>false,
                            'options'=>'title',
                            'url'=>'url',
                            //'url'=>array('/trainingtree/view',array('id'=>'id')),
                    ),
                    'template'=>'{icon}&nbsp;{text}',
                    'persist' => 'location',
                    //'ajaxOptions'=>array('update'=>'#mtreeview-target')
            ));
    ?>
    </div>
    <div id="mtreeview-buttons">
    <?php
        if (Yii::app()->user->checkAccess('moderator'))
        {
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonAddFolder',
                'caption'=>'Добавить раздел',
                'htmlOptions'=>array(
                    'style'=>'height:40px; width:250px; margin-top: 10px; margin-bottom: 10px ',
                    'class'=>'button'
                    ),
                'onclick'=>'js:function(){$("#dialogFolders").dialog("open"); return false;}',
                )
            );
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonAddMaterial',
                'caption'=>'Добавить материал',
                'htmlOptions'=>array(
                    'style'=>'height:40px; width:250px',
                    'class'=>'ui-button-primary'
                    ),
                //'onclick'=>'js:function(){$("#dialogMaterial").dialog("open"); return false;}',
                'onclick'=>'js:function(){window.location = "'.Yii::app()->createUrl('trainingtree/create', array('backurl'=>Yii::app()->request->url)).'"; return false;}',
                )
            );
        }
        ?>
    </div>
</div>

<div id="mtreeview-target">

</div>
  
<div class="demo_box">
<?php
    if (Yii::app()->user->checkAccess('moderator'))
    {
        /* Диалог добавления раздела */
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogFolders',
            'options'=>array(
                'title'=>'Раздел',
                'autoOpen'=>false,
                'modal'=>true,
            ),
        ));
        $models = new Trainingtree;

        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'addfolder1-form',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'form',
                    'enctype'=>'multipart/form-data',
                    'accept-charset'=>'UTF-8',
                ),
                'action' => array('trainingtree/create', 'backurl'=>Yii::app()->request->url), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

            ));
        ?>

        <?php //добавляем каталог?>
        <?php echo $forms->errorSummary($models); ?>
        <br />
        <?php echo 'Родительский раздел'; ?>
        <br />
        <?php echo $forms->dropDownList($models,'parent_id',CHtml::listData(Trainingtree::model()->findAllByAttributes(
                    array('type'=>0)),'id','title'),
                    array('empty' => 'Без раздела'));
        ?>
        <br />
        <?php echo $forms->labelEx($models,'title'); ?>
        <br />
        <?php echo $forms->textField($models,'title',array('maxlength'=>40)); ?>
        <br />
        <?php echo $forms->error($models,'title'); ?>
        <br />
        <?php echo $forms->hiddenField($models,'etype', array('value'=>0)); ?>
        <br />
        <?php// echo CHtml::submitButton($models->isNewRecord ? 'Создать' : 'Сохранить'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Сохранить',
            'htmlOptions'=>array(
                'class'=>'btn btn-primary btn-large'
                ),
            )
        );
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonCancel',
            'caption'=>'Отмена',
            'htmlOptions'=>array(
                'class'=>'btn btn-primary btn-large'
                ),
            'onclick'=>'js:function(){$("#dialogFolders").dialog("close"); return false;}',
            )
        );
        ?>
        <?php $this->endWidget();

        $this->endWidget('zii.widgets.jui.CJuiDialog');
    }
?>
</div><!-- demo box -->

<script src="/js/lightbox.js"></script>