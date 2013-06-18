<div id="content">
<div class="well">
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
                'name' => 'Т и п',
                'value' => '$data->type==0 ? "Раздел" : "Материал"',
                'type' => 'html',
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{delete}',
                'buttons'=>array
                (
                    'view' => array
                    (
                        'label'=>'Добавить в тест',
                       // 'url'=>'Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),
                    
                    'delete' => array
                    (
                        'label'=>'Удалить',
                        'url'=>'Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),

                ),

            ),
    ),
));
?>
</div>
    
<div class="well">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grid2',
    'dataProvider'=>$modelTrain,
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
</div>
    
</div>