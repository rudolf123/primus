<h4>Пройденные тесты</h4>  
<div id="block" class="well">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grid2',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
            'id',
    ),
));
?>
</div>
</div>
