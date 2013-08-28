<div id="content" class="well">
<?php 
    $form=$this->beginWidget('CActiveForm', array(
                'id'=>'question',
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array(
                               //'onsubmit'=>"return false;",// Disable normal form submit 
                               //'onkeypress'=>" if(event.keyCode == 13){ send(); } " //do ajax call when user presses enter key 
                            ),
                'action' => Yii::app()->createUrl('trainingtree/Ajax', array('userlog_id'=>$userlog_id)),
                ));
    echo $form->errorSummary($model);
    $i = 0;
    $k = 0;

    shuffle($questions);
    foreach($questions as $question)
    {
        echo '<div class="questionblock">';
        echo '<div class="questiontext">';
        echo '<h5> Вопрос №'.($k+1).'</h5>';
        echo '<h5>'.$question->text.'</h5>';
        if ($question->image != '')
            echo Chtml::link(
                    CHtml::image('/storage/questionimgs/'.$question->image,'Изображение недоступно!',array(
                        'style'=>'class: imagepreview',
                        )
                    ),'/storage/questionimgs/'.$question->image,array(
                            'rel'=>'lightbox',
                            'title'=>$question->image,
                            )
                    );
        echo '</div>';
        echo '<div class="answerblock">';
        echo '<h5>Варианты ответов:</h5>';
        $answers = Answer::model()->findAllByAttributes(array('question_id'=>$question->id));
        //оптимизировать!!
        $rightanswers = count(Answer::model()->findAllByAttributes(array('question_id'=>$question->id,'isright'=>1)));
        $wronganswers = count(Answer::model()->findAllByAttributes(array('question_id'=>$question->id,'isright'=>0)));
        $parttodisplay = array();
        $parttolist = array();
        if ($wronganswers==0)
        {
            foreach($answers as $answer)
            {  
                list($firstpart, $secondpart) = explode("->", $answer->text);
                $parttodisplay[$firstpart] = $secondpart;
            }   
        }
        shuffle($answers);
        foreach($answers as $answer)
        {
            if ($wronganswers==0)
            {
                list($firstpart, $secondpart) = explode("->", $answer->text);
                echo '<div class="answer">'.$firstpart.' - '.$form->dropDownList($model, 'answerscomp['.$i.']',$parttodisplay).'</div>';
            }
            else
            {
                if ($rightanswers>1)
                    echo '<div class="answer">'.$form->checkBox($model, 'answersmulti['.$i.']',array('value'=>$question->id.';'.$answer->id,'uncheckValue'=>null)).$answer->text.'</div>';
                else
                    echo '<div class="answer">'.$form->radioButton($model, 'answers['.$k.']',array('value'=>$question->id.';'.$answer->id,'uncheckValue'=>null)).$answer->text.'</div>';
            }
            $i++;
        };
        echo '</div>';
        echo '</div>';
        
        $k++;
    }
    echo $form->hiddenField($model,'test_id', array('value'=>$testtreemodel->id));
    
    $this->widget('zii.widgets.jui.CJuiButton', array(
        'name'=>'submit',
        'caption'=>'Завершить',
        'htmlOptions'=>array(
            'class'=>'ui-button-primary'
            ),
        //'onclick'=>'js:function(){send()}',
        )
    );
    
    $this->endWidget(); 
    ?>
</div>
