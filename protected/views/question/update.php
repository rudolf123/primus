<?php 
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonBack',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>$backurl,
                )
            );
 ?>

<h3>Изменение вопроса <?php echo $model->id; ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'backurl'=>$backurl)); ?>