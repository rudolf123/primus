<div id="content">
<h5>Материалы информационной справки</h5>
<div class="well">
<?php
/*
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
));*/

$this->renderPartial('adminhelptree', array('modelHelp'=>$modelHelp));
?>
</div>
    
<h5>Материалы обучения</h5>
<div class="well">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grid2',
    'dataProvider'=>$modelTrain,
    'columns'=>array(
            'id',
            'title',
            array(
                'name' => 'Тип',
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
                        'label'=>'Просмотреть',
                       // 'url'=>'Yii::app()->createUrl("testtree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),

                    'delete'=> array
                    (
                        'label'=>'Удалить',
                    )
                ),

            ),
    ),
));
?>
</div>
    
</div>