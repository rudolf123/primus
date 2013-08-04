<?php 
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonBack',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>$backurl,
                )
            );
 ?>

<h3>Изменение ответа <?php echo $model->id; ?></h3>

<?php echo $this->renderPartial('_formAnswer', array('model'=>$model)); ?>