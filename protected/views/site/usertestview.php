<div id="block" class="well">
<?php
if ($dataProvider)
{
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'grid2',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
                array(
                'name' => 'test_id',
                'value' => 'Testtree::model()->findByPk($data->test_id)->title',
                'type' => 'raw',
                ),
                'starttime',
                array(
                'name' => 'endtime',
                'value' => '$data->endtime==NULL ? "Не закончен" : $data->endtime',
                'type' => 'raw',
                ),
                array(
                'name' => 'grade',
                'value' => '$data->grade==-1 ? "Нет оценки" : $data->grade',
                'type' => 'raw',
                ),
                array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{delete}',
                'viewButtonUrl' => 'Yii::app()->createUrl("site/viewanswerslog", array("id"=>$data->id))',
                'deleteButtonUrl'=> 'Yii::app()->createUrl("site/deletetestlog", array("id"=>$data->id))',
                ),
        ),
    ));
}
?>
</div>
