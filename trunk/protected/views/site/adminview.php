<div id="block">
<?php

    $dataProvider = new CActiveDataProvider('User');

    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', 
        'placement'=>'left',
        'tabs'=>array('tabsOptions'=>array('class'=>'well'),
                array('label'=>'Личный состав', 'content'=>$this->renderPartial('usersView',array('dataProvider' => $dataProvider),true), 'active'=>true),
                array('label'=>'Системные параметры', 'content'=>$this->renderPartial('systemView',false,true)),
            ),
        ));
?>
</div>
