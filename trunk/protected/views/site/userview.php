<div id="content">
<?php
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs',
        'tabs'=>array(
                array('label'=>'Информация', 'content'=>$this->renderPartial('userprofileview',array('model' => $model),true), 'active'=>true),
                array('label'=>'Пройденные тесты', 'content'=>$this->renderPartial('usertestview',array('dataprovider' => $testdataprovider),true)),
            ),
        ));
?>
</div>
