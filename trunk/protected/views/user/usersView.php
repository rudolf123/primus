<?php

    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'aswer-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'surname',
            'name',
            'secondname',
            'block',
            'rank',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{delete}',
                //'viewButtonUrl' => 'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                //'deleteButtonUrl'=> 'Yii::app()->createUrl("question/deleteAnswer", array("id"=>$data->id))',
                /*'buttons'=>array
                (
                    'view' => array
                    (
                        'label'=>'Просмотреть ответ',
                        'url'=>'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                    ),
                    'update' => array
                    (
                        'label'=>'Изменить ответ',
                        'url'=>'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                    ),
                ),*/

            ),
        ),
    ));
?>
