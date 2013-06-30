<div id="content">
<p>
<?php echo CHtml::link('<< назад', Yii::app()->createUrl('site/admin'));?>
</p>
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
