<div id="documentspanel">
   <?php  
        $this->beginWidget('zii.widgets.CPortlet', array(
             )); 
                //echo Chtml::link('sdfsdf',Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>'2260358673_keyboard_1.jpg')), array('img'=>'src=; alt="альтернативный текст">'));
                if ($model->doc != '')
                    echo Chtml::link(CHtml::image('/assets/doc.gif','doc icon is missing',array('width'=>'40px','height'=>'40px')),Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>$model->doc)));
                if ($model->pdf != '')
                    echo Chtml::link(CHtml::image('/assets/pdf.gif','pdf icon is missing',array('width'=>'40px','height'=>'40px')),Yii::app()->createUrl('helptree/DownloadFile',array('filename'=>$model->pdf)));  
                if (Yii::app()->user->checkAccess('moderator'))
                    echo Chtml::link(CHtml::image('/assets/edit.png','edit icon is missing',array()), Yii::app()->createUrl('helptree/update', array('id'=>$model->id)));
                //echo Chtml::link(CHtml::image('/assets/doc.gif','doc icon is missing',array('width'=>'40px','height'=>'40px')),Yii::app()->createUrl('helptree/delete',array('id'=>$model->id)));
                
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
                $this->widget('zii.widgets.jui.CJuiButton', array(
                    'name'=>'buttonchangesize',
                    'caption'=>'Изменить размер',
                    //'value'=>'abc',
                    'htmlOptions'=>array(
                        //'style'=>'height:40px; width:250px',
                        'class'=>'btn btn-primary btn-large'
                        ),
                    'onclick'=>'js:changeSize()',
                    )
                );
        $this->endWidget(); 
               
        ?>
</div>
<div id="HelptreeTitle">
<h3><?php echo $model->title; ?></h3>
</div>


<div id="<?php if (User::model()->findByPk(Yii::app()->user->id)->fixedcontent) 
                    echo 'HelptreeViewContentFix';
               else 
                    echo 'HelptreeViewContent'?>">
    
    <?php if ($model->htmlfield != '')
        echo $model->htmlfield
?>
    
<!--Контейнер в котором мы будем отображать большую картинку-->
<div id="img_container"><img src="" width="1000px"></div>
        <!--Контейнер с миниатюрами-->
<div class="imagepreview">
<?php
        if ($model->img != '')
            echo CHtml::image('/storage/'.$model->img,'Picture is missing');  
?> 
</div>

    <?php
    if ($model->video != '')
    {
        $this->widget('ext.jwplayer.Jwplayer',array(
                'width'=>600,
                'height'=>360,
                'id'=>'HelptreeViewVideo',
                'file'=>'/storage/'.$model->video, // the file of the player, if null we use demo file of jwplayer
                //'image'=>'/assets/doc.jpg', // the thumbnail image of the player, if null we use demo image of jwplayer
                'options'=>array(
                    'controlbar'=>'bottom'
                )
            ));
    }
?>


</div>

<script>
function changeSize() {
$("#HelptreeViewContentFix").attr('height');
};
</script>

<script>
$(document).ready(function () {
    if ($("#mtreeview-target").is('hidden')) {
        $("#mtreeview").fadeOut();
      } 
    //$('#mtreeview-target').
    $('#mtreeview-target').fadeIn('1000');
});
</script>

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

$('#documentspanel').click(function()
{
    (this).fadeOut('slow');
});

</script>