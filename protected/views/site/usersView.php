<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'surname',
            'name',
            'secondname',
            'online',
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
