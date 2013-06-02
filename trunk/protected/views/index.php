<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
    $dataProvider=new CActiveDataProvider('Question');

    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',   // refers to the partial view named '_post'
        'sortableAttributes'=>array(
            'id',
        ),
    ));
?>
