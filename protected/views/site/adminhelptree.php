<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grid',
    'dataProvider'=>$modelHelp,
    //'ajaxUrl' => Yii::app()->createUrl('site/AdminsectionsAjax'),
    //'filter'=>$dataProvider,
    'columns'=>array(
            'id',
            array(
                    'class' => 'bootstrap.widgets.TbEditableColumn',
                    'name' => 'title',
                    'editable' => array(
                        'url' => $this->createUrl('/site/edithelptreetitle'),
                        'placement' => 'right',
                        'inputclass' => 'span3',
                        'title'=>'Введите значение',
                )),
            array(
                'name' => 'type',
                'value' => '$data->type==0 ? "Раздел" : "Материал"',
                'type' => 'html',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array
                (
                    /*'update' => array
                    (
                        'label'=>'Просмотреть',
                        'url'=>'Yii::app()->createUrl("helptree/update", array("id"=>$data->id))',
                    ),*/
                    
                    'delete' => array
                    (
                        'label'=>'Удалить',
                        'url'=>'Yii::app()->createUrl("site/deletehelptree/", array("id"=>$data->id))',
                    ),

                ),

            ),
    ),
));

?>
