<div id="block" class="content">
<?php 
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonBack',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>$backurl,
                )
            );
 ?>
<h3>Просмотр ответов</h3>
<div class="well">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'answers-grid',
	'dataProvider'=>$dataprovider,
	'columns'=>array(
                'question_text',
                'answer_text',
                array(
                'value' => '$data->isright==0 ? "<p class=\'wrong_answer_cell\'>Неверно</p>" : "<p class=\'right_answer_cell\'>Верно</p>"',
                'type' => 'html',
                ),
	),
)); ?>
</div>
</div>
</div>
