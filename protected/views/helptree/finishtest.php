<h3>Тест закончен!</h3>
<?php
echo '<h5>Количество вопросов: '.$questioncount.'</h5>';
echo '<h5>Количество правильных ответов: '.$rightcount.'</h5>';
echo '<h5>Оценка: '.round($grade,2).'</h5>';
if (System::model()->findByPk(1)->value==="yes")
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'grid2',
        'dataProvider'=>$answerslog,
        'columns'=>array(
                array(
                    'value' => '$data->isright==0 ? "<p class=\'wrong_answer_cell\'>Неверно</p>" : "<p class=\'right_answer_cell\'>Верно</p>"',
                    'type' => 'html',
                ),
                'question_text',
                'answer_text',
                'right_answer'
        ),
    ));
?>
<p>
<?php 
    $this->widget('zii.widgets.jui.CJuiButton', array(
        'name'=>'buttonBack',
        'caption'=>'<< Назад (Информационная справка)',
        'htmlOptions'=>array(
            //'style'=>'height:40px; width:250px; ',
            'class'=>'ui-button-primary',
            ),
        'onclick'=>'js:function(){window.location = "'.Yii::app()->createUrl('helptree/view', array('id'=>$test_id)).'"; return false;}',
        )
    );
 ?>
</p>

