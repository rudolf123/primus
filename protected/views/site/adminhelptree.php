<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grid',
    'dataProvider'=>$modelHelp,
    //'ajaxUrl' => Yii::app()->createUrl('site/AdminsectionsAjax'),
    //'filter'=>$dataProvider,
    'columns'=>array(
            'id',
            'title',
            array(
                'name' => 'Тип',
                'value' => '$data->type==0 ? "Раздел" : "Материал"',
                'type' => 'raw',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{delete}',
                'buttons'=>array
                (
                    'view' => array
                    (
                        'label'=>'Просмотреть',
                       // 'url'=>'Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),
                    
                    'delete' => array
                    (
                        'label'=>'Удалить',
                        //'url'=>'Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),

                ),

            ),
    ),
));

?>
