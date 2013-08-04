<h3>Тест закончен!</h3>
<?php
echo '<h5>Количество вопросов: '.$questioncount.'</h5>';
echo '<h5>Количество правильных ответов: '.$rightcount.'</h5>';
echo '<h5>Оценка: '.round($grade,2).'</h5>';
/*$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grid2',
    'dataProvider'=>$answerslog,
    'columns'=>array(
            'id',
            'question_id',
            'answer_id',
            'userlog_id',
            'isright',
            'question_text',
            'answer_text',
    ),
));*/
?>
<p>
<?php 
    $this->widget('zii.widgets.jui.CJuiButton', array(
        'name'=>'buttonBack',
        'caption'=>'<< Назад (Проверка знаний)',
        'htmlOptions'=>array(
            //'style'=>'height:40px; width:250px; ',
            'class'=>'ui-button-primary',
            ),
        'onclick'=>'js:function(){window.location = "'.Yii::app()->createUrl('testtree/viewtest', array('id'=>$test_id)).'"; return false;}',
        )
    );
?>
</p>
