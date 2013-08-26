<?php 
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonViewResults',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>$backurl,
                )
            );
 ?>
<h3>Изменение материала "<?php echo $model->title; ?>"</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'backurl'=>$backurl,)); ?>


<div id="file-uploader"></div>
 
<?php

$filesPath = realpath(Yii::app()->basePath);
$filesUrl = Yii::app()->baseUrl;
 
$this->widget("ext.ezzeelfinder.ElFinderWidget", array(
    'selector' => "div#file-uploader",
    'clientOptions' => array(
        'lang' => "ru",
        'resizable' => false,
        'wysiwyg' => "ckeditor"
    ),
    'connectorRoute' => "helptree/fileUploaderConnector",
    'connectorOptions' => array(
        'roots' => array(
            array(
                'driver'  => "LocalFileSystem",
                'path' => $filesPath,
                'URL' => $filesUrl,
                'tmbPath' => $filesPath . DIRECTORY_SEPARATOR . ".thumbs",
                'mimeDetect' => "internal",
                'accessControl' => "access"
            )
        )
    )
));
 
?>
