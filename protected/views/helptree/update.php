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