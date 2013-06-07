<?php $this->pageTitle=Yii::app()->name; ?>

<div id="block">
    <h4>Список личного состава на занятии</h4>
<?php
  /*  $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'aswer-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'surname',
            'name',
            'secondname',
            'block',
            'rank',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{delete}',
            ),
        ),
    ));*/
    
    
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'bordered',
        'dataProvider'=>$dataProvider,
        'template'=>"{items}",
        //'htmlOptions'=>array('class'=>'well',),
        'columns'=>array(
            'surname',
            'name',
            'secondname',
            'section'
            )
    ));
    
?>

</div>