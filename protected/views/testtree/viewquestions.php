<h2>Доступные вопросы</h2>

<div id="ajaxModerateTable">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'question-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'theme',
            'text',
            'image',
            /*array(
            'name'=>'Add',
            'type'=>'raw',
            'value'=>'CHtml::ajaxButton("Добавить",Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.')), array("update" => "#ajaxModerateTable"))'
            ),*/
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}',
                //'viewButtonUrl' => 'Yii::app()->createUrl("testtree/addquestiontotest", array("id"=>$data->id))',
                //'deleteButtonUrl'=> 'Yii::app()->createUrl("question/deleteAnswer", array("id"=>$data->id))',
                'buttons'=>array
                (
                    'view' => array
                    (
                        'label'=>'Добавить в тест',
                        'url'=>'Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),
                   // 'update' => array
                   // (
                   //     'label'=>'Изменить ответ',
                   //     'url'=>'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                    //),
                ),

            ),
    ),
));
/*
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'question-grid1',
    'dataProvider'=>$testquestions,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'theme',
            'text',
            'image',
            array(
            'name'=>'remove',
            'type'=>'raw',
            'value'=>'CHtml::ajaxButton("Убрать",Yii::app()->createUrl("testtree/RemoveQuestionFromTest", array("question_id"=>$data->id, "test_id"=>'.$model->id.')), array("update" => "#ajaxModerateTable"))'
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}',
                //'viewButtonUrl' => 'Yii::app()->createUrl("testtree/addquestiontotest", array("id"=>$data->id))',
                //'deleteButtonUrl'=> 'Yii::app()->createUrl("question/deleteAnswer", array("id"=>$data->id))',
                'buttons'=>array
                (
                    'view' => array
                    (
                        'label'=>'Добавить в тест',
                        'url'=>'Yii::app()->createUrl("testtree/RemoveQuestionFromTest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),
                   // 'update' => array
                   // (
                   //     'label'=>'Изменить ответ',
                   //     'url'=>'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                    //),
                ),

            ),
    ),
));*/
?>
</div>