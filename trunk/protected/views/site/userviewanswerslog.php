<div id="block" class="content">
<p>
    <a href="javascript:history.back()" onMouseOver="window.status='Назад';return true"><< назад</a>
</p>
<h3>Просмотр ответов</h3>
<div class="well">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'answers-grid',
	'dataProvider'=>$dataprovider,
	'columns'=>array(
                'question_text',
                'answer_text',
                array(
                'value' => '$data->isright==0 ? "Не верный" : "Верный"',
                'type' => 'html',
                ),
	),
)); ?>
</div>
</div>
</div>
