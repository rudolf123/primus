<h4>Проверка знаний</h4>
<div id="leftcolumn">
    <div id="mtreeview">
    <?php
            $this->widget('application.extensions.MTreeView.MTreeView',array(
                    'collapsed'=>true,
                    'animated'=>'fast',
                    //---MTreeView options from here
                    'table'=>'tbl_testtree',//what table the menu would come from
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
                            //'url'=>array('/testtree/viewTest',array('id'=>'id')),
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
                //'value'=>'abc',
                'htmlOptions'=>array(
                    'style'=>'height:40px; width:250px; margin-top: 10px; margin-bottom: 10px ',
                    'class'=>'button'
                    ),
                'onclick'=>'js:function(){$("#dialogFolders").dialog("open"); return false;}',
                )
            );
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonAddMaterial',
                'caption'=>'Добавить тест',
                //'value'=>'abc',
                'htmlOptions'=>array(
                    'style'=>'height:40px; width:250px',
                    'class'=>'ui-button-primary'
                    ),
                'onclick'=>'js:function(){$("#dialogMaterial").dialog("open"); return false;}',
                )
            );
        }
            ?>
    </div>
</div>

<div id="mtreeview-target">
    <h4>Информация о тесте</h4>

    <?php// echo CHtml::link('clickMe', Yii::app()->createUrl('testtree/runtest', array('id'=>$model->id)));
    ?>
    <div id="HelptreeViewContent">
    <?php 
    $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'title',
                    'time',
                    array(               // related city displayed as a link
                        'label'=>'Количество вопросов',
                        'type'=>'raw',
                        'value'=>count($arr_questions),
                        ),
                    array( 
                        'label'=>'Количество ваших попыток',
                        'type'=>'raw',
                        'value'=>$userlogcount,
                        )
            ),
    )); 
    ?>
    <?php 
    if (count($arr_questions)>0)
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonRuntest',
            'caption'=>'Начать тестирование',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px; margin-top: 10px; margin-bottom: 10px',
                'class'=>'ui-button-error',
                ),
            'onclick'=>'js:function(){window.location = "'.Yii::app()->createUrl('testtree/runtest', array('id'=>$model->id)).'"; return false;}',
            )
        );
        //echo Chtml::link('Начать тестирование',Yii::app()->createUrl('testtree/runtest', array('id'=>$model->id)));
    echo '</br>';
    if (Yii::app()->user->checkAccess('moderator'))
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonUpdatetest',
            'caption'=>'Редактировать тест',
            'htmlOptions'=>array(
                'style'=>'height:40px; width:250px; ',
                'class'=>'ui-button-primary',
                ),
            'onclick'=>'js:function(){window.location = "'.Yii::app()->createUrl('testtree/updatetest', array('id'=>$model->id,'backurl'=>Yii::app()->request->url)).'"; return false;}',
            )
        );
            //echo Chtml::link('Редактировать тест',Yii::app()->createUrl('testtree/updatetest', array('id'=>$model->id,'backurl'=>Yii::app()->request->url)));
    ?>

    </div>
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
               /* 'buttons'=>array(
                    'Add Item'=>'js:addItem',
                    'Cancel'=>'js:function(){ $(this).dialog("close");}',
                ),*/
            ),
        ));
        $models = new Testtree;
        //$model->parent_id = $this->model->id;
        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'addtesttree-form',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'well',
                    'accept-charset'=>'UTF-8',
                ),
                'action' => array('testtree/create'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

            ));
        ?>

        <?php //добавляем каталог?>
        <?php echo $forms->errorSummary($models); ?>
        <br />
        <?php echo 'Родительский раздел'; ?>
        <br />
        <?php echo $forms->dropDownList($models,'parent_id',CHtml::listData(Testtree::model()->findAllByAttributes(
                    array('type'=>0)),'id','title'),
                    array('empty' => 'Без раздела'));
        ?>
        <br />
        <?php echo $forms->labelEx($models,'title'); ?>
        <br />
        <?php echo $forms->textField($models,'title',array('maxlength'=>250)); ?>
        <br />
        <?php echo $forms->error($models,'title'); ?>
        <br />
        <?php echo $forms->hiddenField($models,'etype', array('value'=>0)); ?>
        <br />
        <?php //echo CHtml::submitButton($models->isNewRecord ? 'Создать' : 'Сохранить'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit',
            'caption'=>'Сохранить',
            //'value'=>'abc',
            'htmlOptions'=>array(
                //'style'=>'height:40px; width:250px',
                'class'=>'btn btn-primary btn-large'
                ),
            )
        );
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonCancel',
            'caption'=>'Отмена',
            //'value'=>'abc',
            'htmlOptions'=>array(
                //'style'=>'height:40px; width:250px',
                'class'=>'btn btn-primary btn-large'
                ),
            'onclick'=>'js:function(){$("#dialogFolders").dialog("close"); return false;}',
            )
        );
        ?>
        <?php $this->endWidget();

        $this->endWidget('zii.widgets.jui.CJuiDialog');

          //  echo CHtml::link('Добавить раздел', '#', array(
         //       'onclick'=>'$("#dialogFolders").dialog("open"); return false;',
        //));

        ?>

    <?php
    
        /* Диалог добавления раздела */
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogMaterial',
            'options'=>array(
                'title'=>'Тест',
                'autoOpen'=>false,
                'modal'=>true,
                /*'buttons' => array(
                    array('text'=>'OK','click'=> 'js:function(){
                                                    $.post(
                                                    $("#addfolder-form").attr("action"), // the url to submit to
                                                    $("#addfolder-form").serialize(), // the data is serialized
                                                    function(){$(this).dialog("close");} // in the success the dialog is closed
                                                );
                                           }',
                        ),
                    array('text'=>'Отмена','click'=> 'js:function(){$(this).dialog("close");}'),
                    ),*/
            ),
        ));
        $model = new Testtree;
        //$model->parent_id = $this->model->id;
        $form = $this->beginWidget('CActiveForm', array(
                'id' => 'addfolder-form',
                'enableClientValidation' => true,
               // 'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'well',
                    'accept-charset'=>'UTF-8',
                ),
                'action' => array('testtree/create'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

            ));
        ?>

        <?php //добавляем материал?>
        <?php echo $form->errorSummary($model); ?>
        <br />
        <?php echo 'Родительский раздел'; ?>
        <br />
        <?php echo $form->dropDownList($model,'parent_id',CHtml::listData(Testtree::model()->findAllByAttributes(
                    array('type'=>0)),'id','title'),
                    array('empty' => 'Без раздела'));
        ?>
        <br />
        <?php echo $form->labelEx($model,'title'); ?>
        <br />
        <?php echo $form->textField($model,'title',array('maxlength'=>255)); ?>
        <br />
        <?php echo $form->error($model,'title'); ?>
        <br />
        <?php echo $form->labelEx($model,'time'); ?>
        <br />
        <?php echo $form->textField($model,'time'); ?>
        <br />
        <?php echo $form->error($model,'time'); ?>
        <br />
        <?php echo $form->hiddenField($model,'etype', array('value'=>1)); ?>
        <br />
        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit1',
            'caption'=>'Сохранить',
            //'value'=>'abc',
            'htmlOptions'=>array(
               // 'style'=>'height:20px; width:100px',
                'class'=>'btn btn-primary btn-large'
                ),
            )
        );
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonCancel1',
            'caption'=>'Отмена',
            //'value'=>'abc',
            'htmlOptions'=>array(
                //'style'=>'height:40px; width:250px',
                'class'=>'btn btn-primary btn-large'
                ),
            'onclick'=>'js:function(){$("#dialogMaterial").dialog("close"); return false;}',
            )
        );
        ?>
        <?php $this->endWidget();

        $this->endWidget('zii.widgets.jui.CJuiDialog');


      //  echo CHtml::link('Добавить материал', '#', array(
      //      'onclick'=>'$("#dialogFolder").dialog("open"); return false;',
      //  ));
    
    }// if checkaccess;
    ?>

</div><!-- demo box -->