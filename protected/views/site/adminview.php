<div id="block" class="well">
<?php

    $dataProvider = new CActiveDataProvider('User');

    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', 
        'placement'=>'left',
        'tabs'=>array(
                array('label'=>'Личный состав', 'content'=>$this->renderPartial('usersView',array('dataProvider' => $dataProvider),true), 'active'=>true),
                array('label'=>'Системные параметры', 'content'=>$this->renderPartial('systemView',false,true)),
                array('label'=>'База данных', 'content'=>'Messages Content'),
            ),
        ));
?>
</div>
