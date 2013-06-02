<h2>Информационная справка</h2>

<div id="mtreeview" style="width: 250px;border: 1px solid GRAY;float:left">
<?php
	$this->widget('application.extensions.MTreeView.MTreeView',array(
		'collapsed'=>true,
		'animated'=>'fast',
		//---MTreeView options from here
		'table'=>'tbl_helptree',//what table the menu would come from
		'hierModel'=>'adjacency',//hierarchy model of the table
		//'conditions'=>array('visible=:visible',array(':visible'=>1)),//other conditions if any                                    
		'fields'=>array(//declaration of fields
			'text'=>'title',//no `text` column, use `title` instead
			'alt'=>'title',//skip using `alt` column
			'id_parent'=>'parent_id',//no `id_parent` column,use `parent_id` instead
			'position'=>'title',
			'task'=>false,
			'options'=>'title',
			'url'=>array('/helptree/view',array('id'=>'id'))
		),
		'template'=>'{icon}&nbsp;{text}',
		'ajaxOptions'=>array('update'=>'#mtreeview-target')
	));
?>
</div>
<div id="mtreeview-target" style="border: 1px solid gray;margin-left: 260px;min-height: 300px">
Click on any link of the tree at the left...
</div>

<div class="example_title">Simple dialog</div>

<div class="demo_box">
<?php
    /* Диалог добавления раздела */
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogFolder',
        'options'=>array(
            'title'=>'Каталог',
            'autoOpen'=>false,
            'modal'=>true,
           /* 'buttons'=>array(
                'Add Item'=>'js:addItem',
                'Cancel'=>'js:function(){ $(this).dialog("close");}',
            ),*/
        ),
    ));
    $model = new Helptree; 
    //$model->parent_id = $this->model->id;
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'addfolder-form',
            //'enableClientValidation' => true,
            'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
            //'clientOptions' => array(
           //         'validateOnSubmit' => true,
            //        'validateOnChange' => true,
            //    ),
            'htmlOptions'=>array(
                'class'=>'form',
                'enctype'=>'multipart/form-data',
                'accept-charset'=>'UTF-8',
            ),
            'action' => array('helptree/create'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')
    
        ));
    ?>
    <?php //добавляем каталог?>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->labelEx($model,'Кодовое обозначение раздела'); ?>
    <br />
    <?php echo $form->textField($model,'id'); ?>
    <br />
    <?php echo $form->error($model,'id'); ?>
    <br />
    <?php echo $form->labelEx($model,'parent_id'); ?>
    <br />
    <?php echo $form->textField($model,'parent_id'); ?>
    <br />
    <?php echo $form->error($model,'parent_id'); ?>
    <br />
    <?php echo $form->labelEx($model,'Наименование раздела'); ?>
    <br />
    <?php echo $form->textField($model,'title',array('maxlength'=>40)); ?>
    <br />
    <?php echo $form->error($model,'title'); ?>
    <?php// echo $form->labelEx($model,'tooltip'); ?>
    <?php echo $form->hiddenField($model,'type', array('value'=>0)); ?>
    <?php// echo $form->error($model,'tooltip'); ?>
    <?php// echo $form->labelEx($model,'url'); ?>
    <?php// echo $form->textField($model,'url',array('maxlength'=>255)); ?>
    <?php// echo $form->error($model,'url'); ?>
    <?php// echo $form->hiddenField($model,'icon',array('value'=>'folder_key.png')); ?>
    <?php //Поле загрузки файла
    //echo CHtml::activeFileField($model, 'image'); ?>
    <br />
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>

    <?php $this->endWidget();
    
    $this->endWidget('zii.widgets.jui.CJuiDialog');

    
        /* Диалог добавления материала */
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogMaterial',
        'options'=>array(
            'title'=>'Материал',
            'autoOpen'=>false,
            'modal'=>true,
           /* 'buttons'=>array(
                'Add Item'=>'js:addItem',
                'Cancel'=>'js:function(){ $(this).dialog("close");}',
            ),*/
        ),
    ));
    $model = new Helptree; 
    //$model->parent_id = $this->model->id;
    $form = $this->beginWidget('CActiveForm', array(
            'id' => 'addmaterial-form',
            //'enableClientValidation' => true,
            'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
            //'clientOptions' => array(
           //         'validateOnSubmit' => true,
            //        'validateOnChange' => true,
            //    ),
            'htmlOptions'=>array(
                'class'=>'form',
                'enctype'=>'multipart/form-data',
                'accept-charset'=>'UTF-8',
            ),
            'action' => array('helptree/create'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')
    
        ));
    ?>
    <?php //добавляем материал?>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->labelEx($model,'Кодовое обозначение материала'); ?>
    <br />
    <?php echo $form->textField($model,'id'); ?>
    <br />
    <?php echo $form->error($model,'id'); ?>
    <br />
    <?php echo $form->labelEx($model,'parent_id'); ?>
    <br />
    <?php echo $form->textField($model,'parent_id'); ?>
    <br />
    <?php echo $form->error($model,'parent_id'); ?>
    <br />
    <?php echo $form->labelEx($model,'Наименование материала'); ?>
    <br />
    <?php echo $form->textField($model,'title',array('id'=>'abra1','maxlength'=>40)); ?>
    <br />
    <?php echo $form->error($model,'title'); ?>
    <br />
    <?php echo $form->labelEx($model,'Тип материала',array('id'=>'abra')); ?>
    <br />
    <?php echo $form->dropDownList($model, 'type', 
              array(1 => 'Male', 2 => 'Female'),array(
             'onclick'=>'$("#abra1").value = 1; return false;',
    ));?>
    
    <?php// echo $form->labelEx($model,'tooltip'); ?>
    <?php echo $form->hiddenField($model,'type', array('value'=>1)); ?>
    <?php// echo $form->error($model,'tooltip'); ?>
    <?php// echo $form->labelEx($model,'url'); ?>
    <?php// echo $form->textField($model,'url',array('maxlength'=>255)); ?>
    <?php// echo $form->error($model,'url'); ?>
    <?php// echo $form->hiddenField($model,'icon',array('value'=>'folder_key.png')); ?>
    <?php //Поле загрузки файла
    //echo CHtml::activeFileField($model, 'image'); ?>
    <br />
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>

    <?php $this->endWidget();
    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    
    //echo CHtml::labelEx('456');
    echo CHtml::button('text',array(
            'onclick'=>'$("#dialogFolder").dialog("open"); return false;'
            ));
    echo CHtml::textField('text', 'text', array(
       // 'onclick'=>'$("#123").value = 1; return false;',
      //  'id'=>'123'
    ));
        echo CHtml::textField('text1', 'text1', array(
             'onChange'=>"$('text').value = '123';alert('test');",
    ));
    echo CHtml::link('Create folder123', array('/helptree/view'));
    echo CHtml::link('Добавить раздел', '#', array(
            'onclick'=>'$("#dialogFolder").dialog("open"); return false;',
    ));
    
    echo CHtml::link('Добавить материал', '#', array(
            'onclick'=>'$("#dialogMaterial").dialog("open"); return false;',
    ));
?>
    <?php echo CHtml::ajaxLink('Create folder','CreateFolder')?>
    <script type="text/javascript" >
    function addItem(){
        $(this).dialog("close");
        alert( $("#item-name-input").val() + " has been added");
    }
</script>
</div><!-- demo box -->