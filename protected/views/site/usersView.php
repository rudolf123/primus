<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'surname',
            'name',
            'secondname',
            array(
                'name' => 'online',
                'value' => '$data->online==0 ? "Нет" : "Да"',
                'type' => 'raw',
            ),
            array(
                'name' => 'role',
                'value' => '$data->role=="moderator" ? "Преподаватель" : "Обучаемый"',
                'type' => 'raw',
            ),
            'block',
            'rank',
            'regdate',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{delete}',
                'viewButtonUrl' => 'Yii::app()->createUrl("site/viewuser", array("id"=>$data->id))',
                'deleteButtonUrl'=> 'Yii::app()->createUrl("site/deleteuser", array("id"=>$data->id))',
            ),
        ),
    ));
    
    
?>
