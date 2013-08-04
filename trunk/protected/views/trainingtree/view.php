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
    <div id="documentspanel">
       <?php  
            $this->beginWidget('zii.widgets.CPortlet', array(
                 )); 
                    //echo Chtml::link('sdfsdf',Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>'2260358673_keyboard_1.jpg')), array('img'=>'src=; alt="альтернативный текст">'));
                    if ($model->doc != '')
                        echo Chtml::link(CHtml::image('/assets/doc.png','doc icon is missing',array('width'=>'40px','height'=>'40px','title'=>'Скачать в формате Word')),Yii::app()->createUrl('trainingtree/DownloadFile',array('filename'=>$model->doc)));
                    if ($model->pdf != '')
                        echo Chtml::link(CHtml::image('/assets/pdf.png','pdf icon is missing',array('width'=>'40px','height'=>'40px','title'=>'Скачать в формате PDF')),Yii::app()->createUrl('trainingtree/DownloadFile',array('filename'=>$model->pdf)));
                    if ($model->program != '')
                        echo Chtml::link(CHtml::image('/assets/gear.png','program icon is missing',array('width'=>'40px','height'=>'40px','title'=>'Скачать программу')),Yii::app()->createUrl('trainingtree/DownloadFile',array('filename'=>$model->program))); 
                    if (Yii::app()->user->checkAccess('moderator'))
                        echo Chtml::link(CHtml::image('/assets/edit.png','edit icon is missing',array('title'=>'Изменить материал')), Yii::app()->createUrl('trainingtree/update', array('id'=>$model->id, 'backurl'=>Yii::app()->request->url)));
                    if (Yii::app()->user->checkAccess('moderator'))
                        echo Chtml::link(CHtml::image('/assets/question.png','question icon is missing',array('title'=>'Изменить вопросы самоконтроля')), Yii::app()->createUrl('trainingtree/manageQuestions', array('id'=>$model->id, 'backurl'=>Yii::app()->request->url)));                
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
                        //'visible' => Yii::app()->user->checkAccess('print'),  //should this be visible to the current user?
                        'alt' => 'print',       //text which will appear if image can't be loaded
                        'debug' => false,            //enable the debugger to see what you will get
                        //'id' => 'documentspanel'         //id of the print link
                    ));        
            $this->endWidget(); ?>

    </div>

    <div id="HelptreeTitle">
    <h5>
        <?php 
            echo $model->title; 
            echo '<div class="toolbox"><a id="wideView" class="fix" href="#" title="Свернуть/развернуть"></a></div>';
        ?>
    </h5>
    </div>

    <div id="HelptreeViewContent" class="fix">
    <?php 
        //если есть, вывоим текстовое содержимое
        if ($model->htmlfield != '')
            echo $model->htmlfield;
        //если есть, вывоим изображение
        if ($model->img != '')
        {
            echo Chtml::link(
                    CHtml::image('/storage/training/'.$model->img,'Изображение недоступно!',array(
                        'style'=>'class: imagepreview',
                        )),
                    '/storage/training/'.$model->img,array(
                        'rel'=>'lightbox',
                        'title'=>$model->img,
                        )
                    );
        }
        //если есть, вывоим видео
        if ($model->video != '')
        {
            $this->widget('ext.jwplayer.Jwplayer',array(
                    'width'=>600,
                    'height'=>360,
                    'id'=>'HelptreeViewVideo',
                    'file'=>'/storage/training/'.$model->video,
                    //'image'=>'/assets/doc.jpg', // the thumbnail image of the player, if null we use demo image of jwplayer
                    'options'=>array(
                        'controlbar'=>'bottom'
                    ),

                ));
        }
    ?>
    </div>

    <?php 
        if (Trainingquestion::model()->findByAttributes(array('training_id'=>$model->id)))
        {
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonRuntest',
                'caption'=>'Пройти самоконтроль!',
                'buttonType'=>'link',
                'url'=>Yii::app()->createUrl('trainingtree/runtest', array('id'=>$model->id)),
                )
            );
        }

        if (Trainingquestion::model()->findByAttributes(array('training_id'=>$model->id)))
        {
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonViewResults',
                'caption'=>'Показать результаты самоконтроля!',
                'buttonType'=>'link',
                'url'=>Yii::app()->createUrl('trainingtree/runtest', array('id'=>$model->id)),
                )
            );
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

<script type="text/javascript" >
$(document).ready(function() {

// При клике на миниатюру
$('.imagepreview img').click(function()
{
// Берем свойство SRC миниатюры
// (можно картинку положить в ссылку и брать значение href
// для того, чтобы не грузить большие картинки изначально
// а загружать сначало миниатюры и только при клике открывать
// большое изображение, что будет целесообразнее).
var imgSrc = $(this).attr("src");
// Задаем свойство SRC картинке, которая в скрытом диве.
$('#img_container img').attr({src: imgSrc});
// Показываем скрытый контейнер
$('#img_container').fadeIn('slow');
});
// По клику на большое изображение, скрываем его
$('#img_container').click(function()
{
$(this).fadeOut();
});

});

</script>