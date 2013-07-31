<h5>Доступные вопросы</h5>
<div id="ajaxModerateTable" class="well">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'question-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'skin'=>'false',
    'columns'=>array(
            'theme',
            'text',
            'image',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{add}',
                'buttons'=>array
                (
                    'add' => array
                    (
                        'label'=>'Добавить в тест',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/assets/plus.png',
                        'url'=>'Yii::app()->createUrl("helptree/addquestiontotest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),
                ),

            ),
    ),
));

?>
</div>