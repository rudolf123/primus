<?php 
            $this->widget('zii.widgets.jui.CJuiButton', array(
                'name'=>'buttonBack',
                'caption'=>'<<< Назад',
                'buttonType'=>'link',
                'url'=>$backurl,
                )
            );
 ?>

<?php
    if (System::model()->findByAttributes(array('id'=>1))->value==="yes")
    {
        $counter = 0;
        foreach ($logs as $log)
        {
            echo '<div id="block" class="well">';
            $counter++;
            echo '<h4>Попытка № '.$counter.'</h4>';
            echo '<br />';
            $answerslog = new CActiveDataProvider('Userloganswerstraining', array(
                        'criteria' => array(
                        'condition' => 'userlog_id = :param_userlog_id',
                        'params' => array(':param_userlog_id' => $log->id),
                        ),
            ));
            $this->widget('zii.widgets.CDetailView', array(
                'data'=>$log,
                'attributes'=>array(
                        'starttime',
                        'endtime',
                        'grade'
                ),
            )); 

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

            echo '</div>';
        }
    }
    else
        echo '<h3>Просмотр результатов запрещен системными настройками</h3>';
?>
