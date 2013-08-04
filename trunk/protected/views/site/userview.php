<div id="content">
<?php 
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonBack',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>$backurl,
                )
            );
 ?>
<h3>Просмотр профиля пользователя: <?php echo $model->login?></h3> 
<?php
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs',
        'tabs'=>array(
                array('label'=>'Информация', 'content'=>$this->renderPartial('userprofileview',array('model' => $model),true), 'active'=>true),
                array('label'=>'Пройденные тесты', 'content'=>$this->renderPartial('usertestview',array('dataProvider' => $testdataprovider),true)),
            ),
        ));
?>
</div>
