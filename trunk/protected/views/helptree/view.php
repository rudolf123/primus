<h4>Информационная справка</h4>

<div id="leftcolumn">
    <div id="mtreeview">
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
                            'position'=>'type',
                            'task'=>false,
                            'options'=>'title',
                            'url'=>'url',
                            //'url'=>array('/helptree/view',array('id'=>'id')),
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
                    'style'=>'height:40px; width:250px;  margin-top: 10px; margin-bottom: 10px',
                    ),
                'onclick'=>'js:function(){$("#dialogFolders").dialog("open"); return false;}',
                )
            );
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonAddMaterial',
                'caption'=>'Добавить материал',
                'htmlOptions'=>array(
                    'style'=>'height:40px; width:250px; ',
                    'class'=>'ui-button-primary',
                    ),
                'onclick'=>'js:function(){window.location = "'.Yii::app()->createUrl('helptree/create', array('backurl'=>Yii::app()->request->url)).'"; return false;}',
                )
            );
        }
        ?>

    </div>
</div>

<div id="mtreeview-target">
    <div id="documentspanel">
       <?php  
            $this->beginWidget('zii.widgets.CPortlet', array(
                 )); 
                    //echo Chtml::link('sdfsdf',Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>'2260358673_keyboard_1.jpg')), array('img'=>'src=; alt="альтернативный текст">'));
                    if ($model->doc != '')
                        echo Chtml::link(CHtml::image('/assets/doc.png','doc icon is missing',array('width'=>'40px','height'=>'40px','title'=>'Скачать в формате Word')),Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>$model->doc)));
                    if ($model->pdf != '')
                        echo Chtml::link(CHtml::image('/assets/pdf.png','pdf icon is missing',array('width'=>'40px','height'=>'40px','title'=>'Скачать в формате PDF')),Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>$model->pdf)));  
                    if (Yii::app()->user->checkAccess('moderator'))
                        echo Chtml::link(CHtml::image('/assets/edit.png','edit icon is missing',array('title'=>'Изменить материал')), Yii::app()->createUrl('helptree/update', array('id'=>$model->id, 'backurl'=>Yii::app()->request->url)));
                    //echo Chtml::link(CHtml::image('/assets/doc.gif','doc icon is missing',array('width'=>'40px','height'=>'40px')),Yii::app()->createUrl('helptree/delete',array('id'=>$model->id)));
                    if (Yii::app()->user->checkAccess('moderator'))
                        echo Chtml::link(CHtml::image('/assets/question.png','question icon is missing',array('title'=>'Изменить вопросы самоконтроля')), Yii::app()->createUrl('helptree/manageQuestions', array('id'=>$model->id,'backurl'=>Yii::app()->request->url)));
                    $this->widget('ext.mPrint.mPrint', array(
                        'title' => $model->title,          //the title of the document. Defaults to the HTML title
                        'tooltip' => 'Печать',        //tooltip message of the print icon. Defaults to 'print'
                        'text' => '',   //text which will appear beside the print icon. Defaults to NULL
                        'element' => '#HelptreeViewContent',        //the element to be printed.
                        'exceptions' => array(       //the element/s which will be ignored
                            '.summary',
                            '.search-form'
                        ),
                        'publishCss' => true,       //publish the CSS for the whole page?
                        'alt' => 'print',       //text which will appear if image can't be loaded
                        'debug' => false,            //enable the debugger to see what you will get
                    ));
            $this->endWidget(); 
        ?>
    </div>
    <div id="HelptreeTitle">
        <h5><?php echo $model->title; echo '<div class="toolbox"><a id="wideView" class="fix" href="#" title="Свернуть/развернуть"></a></div>';?></h5>
    </div>

    <div id="HelptreeViewContent" class='fix'>
        <?php 
            if ($model->htmlfield != '')
                echo $model->htmlfield;

            if ($model->img != '')
                echo Chtml::link(
                        CHtml::image('/storage/'.$model->img,'Изображение недоступно!',array(
                            'style'=>'class: imagepreview',
                            )
                        ),'/storage/'.$model->img,array(
                                'rel'=>'lightbox',
                                'title'=>$model->img,
                                )
                        );

            if ($model->video != '')
            {
                $this->widget('ext.jwplayer.Jwplayer',array(
                        'width'=>600,
                        'height'=>360,
                        'id'=>'HelptreeViewVideo',
                        'file'=>'/storage/video/'.$model->video, // the file of the player, if null we use demo file of jwplayer
                        //'image'=>'/assets/doc.jpg', // the thumbnail image of the player, if null we use demo image of jwplayer
                        'options'=>array(
                            'controlbar'=>'bottom'
                        )
                    ));
            }
        ?>
    </div>
        <?php 
        if (Helpquestion::model()->findByAttributes(array('help_id'=>$model->id)))
        {
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonRuntest',
                'caption'=>'Пройти самоконтроль',
                'htmlOptions'=>array(
                    'style'=>'height:40px; width:250px; margin-top: 10px; margin-bottom: 10px',
                    'class'=>'ui-button-error',
                    ),
                'onclick'=>'js:function(){window.location = "'.Yii::app()->createUrl('helptree/runtest', array('id'=>$model->id)).'"; return false;}',
                )
            );
            /*$this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonRuntest',
                'caption'=>'Пройти самоконтроль!',
                'buttonType'=>'link',
                'url'=>Yii::app()->createUrl('helptree/runtest', array('id'=>$model->id)),
                )
            );*/
        }
        
        //if (System::model()->findByAttributes(array('id'=>1))->value==="yes")
            if (Userloghelp::model()->findByAttributes(array('test_id'=>$model->id, 'user_id'=>Yii::app()->user->id)))
            {
                $this->widget('zii.widgets.jui.CJuiButton', array(
                    'name'=>'buttonViewResults',
                    'caption'=>'Результаты самоконтроля',
                    'htmlOptions'=>array(
                        'style'=>'height:40px; width:250px; ',
                        'class'=>'ui-button-primary',
                        ),
                    'onclick'=>'js:function(){window.location = "'.Yii::app()->createUrl('helptree/viewresults', array('id'=>$model->id,'backurl'=>Yii::app()->request->url)).'"; return false;}',
                    )
                );

               /* $this->widget('zii.widgets.jui.CJuiButton', array(
                    'name'=>'buttonViewResults',
                    'caption'=>'Показать результаты самоконтроля!',
                    'buttonType'=>'link',
                    'url'=>Yii::app()->createUrl('helptree/viewresults', array('id'=>$model->id,'backurl'=>Yii::app()->request->url  )),
                    )
                );*/
            }
    ?>
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
        $models = new Helptree;

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
                'action' => array('helptree/createfolder', 'backurl'=>Yii::app()->request->url), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

            ));
        ?>

        <?php //добавляем каталог?>
        <?php echo $forms->errorSummary($models); ?>
        <br />
        <?php echo 'Родительский раздел'; ?>
        <br />
        <?php echo $forms->dropDownList($models,'parent_id',CHtml::listData(Helptree::model()->findAllByAttributes(
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
        <?php $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'submit1',
            'caption'=>'Сохранить',
            'htmlOptions'=>array(
                'class'=>'btn btn-primary btn-large'
                ),
            )
        );
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonCancel1',
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
</div>
<script>
        $(document).ready(function() {
            $("#wideView").click(function() {
                $("#HelptreeViewContent").toggleClass("fix");
                $(this).toggleClass("fix");
            });
        });
</script>
<script src="/js/lightbox.js"></script>

<script>
        $(document).ready(function(){
            function timer()
            {
                $.ajax({
                        type: "POST",
                        url:    "<? echo Yii::app()->createUrl('helptree/keepAliveStatus',array('val1'=>'11','val2'=>'22')); ?>",
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
            
        });
        $('#mtreeview').fadeout('slow', function() {

        });
        

</script>
    <script type="text/javascript" >
    function addItem(){
        $(this).dialog("close");
        alert( $("#item-name-input").val() + " has been added");
    }
</script>