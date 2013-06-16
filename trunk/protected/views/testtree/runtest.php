<div id="content" class="well">
<?php 
    $form=$this->beginWidget('CActiveForm', array(
                'id'=>'question',
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array(
                               'onsubmit'=>"return false;",// Disable normal form submit 
                               'onkeypress'=>" if(event.keyCode == 13){ send(); } " //do ajax call when user presses enter key 
                            ),
                'action' => array('helptree/create'),
                ));
    echo $form->errorSummary($model);
    $i = 0;
    $j = 0;
    $pattern = ' ';
    $replace = '_';

    foreach ($arr_questions as $question)
    {
        echo '<div class="questionblock">';
        $data = array();
       // $data['11'] = 11;
        //$data['12'] = 12;
        //$data['13'] = 13;
        //$data = array('11'=>11,'12'=>12,'13'=>13);
        echo '<div class="questiontext">';
        echo '<h5> Вопрос №'.($i+1).'</h5>';
        echo '<h5>'.$question.'</h5>';
        echo '</div>';
        //echo '<ul class="answers">';
        echo '<div class="answerblock">';
        echo '<h5>Варианты ответов:</h5>';
        foreach($arr_answers[$i++] as $answer)
        {
            $answer2 = str_replace($pattern, $replace, $answer);
            $data[$answer2] = $answer2;
            echo '<div class="answer">'.$form->radioButton($model, 'answers['.$i.']',array('value'=>$answer2,'uncheckValue'=>null)).$answer.'</div>';
          //  echo '<br />';
           // echo $form->textField($model,'answers['.$j.']'); 
            //echo '<br />';
            //echo $form->error($model,'name');

            // echo '<li>';
            //echo '<label>';
            //echo '<input type="radio" data-key="'.$j.'" name="q'.$i.'">';
            //echo $answer2;
            //echo '</label>';
            //echo '</li>';*/
            $j++;
        };
        echo '</div>';
        
        
        //echo $form->radioButtonList($model, 'answers['.$j.']',$data);
        //echo '</ul>';
        echo '</div>';
    }


    echo CHtml::Button('SUBMIT',array('onclick'=>'send();')); 
    $this->endWidget(); 
    ?>
</div>
<script type="text/javascript">
    function send()
    {

       var data=$("#question").serialize();


        $.ajax({
            type: 'POST',
            url: "<? echo Yii::app()->createUrl('testtree/Ajax'); ?>",
            data:data,
            success:function(data){
                alert(data); 
                    },
            error: function(data) { // if error occured
                alert("Error occured.please try again");
                alert(data);
          },

        dataType:'html'
        });
    }
</script>
