<?php 
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonViewResults',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>$backurl,
                )
            );
 ?>


<h3>Новый материал</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>