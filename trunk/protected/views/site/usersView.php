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
            'block',
            'rank',
            'regdate',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{delete}',
            ),
        ),
    ));
    
    
?>
