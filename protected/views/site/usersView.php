<?php

    $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
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
            array(
                'name' => 'block',
                'value' => 'Block::model()->findByPk($data->block)->name',
                'type' => 'raw',
            ),
            array(
                'name' => 'rank',
                'value' => 'Rank::model()->findByPk($data->rank)->name',
                'type' => 'raw',
            ),
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
