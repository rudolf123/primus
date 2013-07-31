<h3>Тест закончен!</h3>
<?php
echo '<h5>Количество вопросов: '.$questioncount.'</h5>';
echo '<h5>Количество правильных ответов: '.$rightcount.'</h5>';
echo '<h5>Оценка: '.round($grade,2).'</h5>';

echo 123;
foreach ($answerslog as $answerlog)
    echo $answerlog->id;
$this->widget('zii.widgets.grid.CGridView', array(
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
));
?>
