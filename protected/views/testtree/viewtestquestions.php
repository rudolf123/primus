<h5>Вопросы в тесте</h5>
<div id="ajaxModerateTableTestQuestions" class="well">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'testquestion-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'theme',
            'text',
            'image',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{remove}',
                'buttons'=>array
                (
                    'remove' => array
                    (
                        'label'=>'Убрать из теста',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/assets/minus.png',
                        'url'=>'Yii::app()->createUrl("testtree/removequestionfromtest", array("question_id"=>$data->id, "test_id"=>'.$model->id.'))',
                    ),
                ),

            ),
    ),
));

?>
</div>