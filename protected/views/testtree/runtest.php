<?php 
    $form=$this->beginWidget('CActiveForm', array(
                'id'=>'question',
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array(
                               'onsubmit'=>"return false;",/* Disable normal form submit */
                               'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
                            ),
                ));
    echo $form->errorSummary($model);
    $i = 0;
    $j = 0;
    foreach ($arr_questions as $question)
    {
        $data = array();
       // $data['11'] = 11;
        //$data['12'] = 12;
        //$data['13'] = 13;
        //$data = array('11'=>11,'12'=>12,'13'=>13);
        echo $question;
        echo '<br />';
        foreach($arr_answers[$i++] as $answer)
        {
            $data[$answer] = $answer;
           // echo $answer;
          //  echo '<br />';
           // echo $form->textField($model,'answers['.$j.']'); 
            //echo '<br />';
            //echo $form->error($model,'name');
            $j++;
        };
        
        echo $form->radioButtonList($model, 'answers['.$j.']',$data);
    }
    echo CHtml::Button('SUBMIT',array('onclick'=>'send();')); 
    $this->endWidget(); 
    ?>

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
