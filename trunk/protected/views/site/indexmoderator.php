<?php $this->pageTitle=Yii::app()->name; ?>

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
        'columns'=>array(
            'surname',
            'name',
            'secondname',
            'block',
            'rank',
            )
    ));
    
?>