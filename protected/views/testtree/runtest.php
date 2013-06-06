<?php

echo 'asdfasdgeiorjgerjge';
$i = 0;
foreach ($arr_questions as $question)
{
?>
    <br/>
<?php    
    echo $question;
?>
    <form id="questionBox" method="post" action="test.php">
    <ul>
    </ul>
    <p><input type="hidden" name="num" value="" />
    <input type="hidden" name="submitter" value="TRUE" />
    <input type="submit" id="submit" name="submit" value="Submit Answer" /></p>
    </form>
    
    <?php
    //$answers = Answer::model()->findAllByAttributes(array('question_id'=>$question->id));
    foreach($arr_answers[$i++] as $answer)
    {
        echo '<br/>';
        echo $answer;
        echo $question;
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
