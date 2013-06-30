<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grid2',
    'dataProvider'=>$modelTrain,
    'columns'=>array(
            'id',
            array(
                    'class' => 'bootstrap.widgets.TbEditableColumn',
                    'name' => 'title',
                    'editable' => array(
                        'url' => $this->createUrl('/site/edittrainingtreetitle'),
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
                    /*'view' => array
                    (
                        'label'=>'Просмотреть',
                       // 'url'=>'Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),*/

                    'delete'=> array
                    (
                        'label'=>'Удалить',
                        'url'=>'Yii::app()->createUrl("site/deletetrainingtree/", array("id"=>$data->id))',
                    )
                ),

            ),
    ),
));

?>
