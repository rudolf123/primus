<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grid',
    'dataProvider'=>$modelHelp,
    'ajaxUrl' => Yii::app()->createUrl('/module/controller/action'),
    //'filter'=>$dataProvider,
    'columns'=>array(
            'id',
            'title',
            array(
                'name' => 'Т и п',
                'value' => '$data->type==0 ? "Раздел" : "Материал"',
                'type' => 'html',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}',
                'buttons'=>array
                (
                    'view' => array
                    (
                        'label'=>'Добавить в тест',
                       // 'url'=>'Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),

                ),

            ),
    ),
));
?>
