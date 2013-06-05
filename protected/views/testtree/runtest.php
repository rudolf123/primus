<?php

echo 'asdfasdgeiorjgerjge';

foreach ($dataProvider as $question)
{
?>
    <br/>
<?php    
    echo $question->text;
    $answers = Answer::model()->findAllByAttributes(array('question_id'=>$question->id));
    foreach($answers as $answer)
    {
?>
        <br/>
    <?php 
    echo CHtml::checkBox('dfgdfg');
    echo '<br/>';
    echo $answer->text;
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
