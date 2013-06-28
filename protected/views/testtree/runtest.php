<div id="content" class="well">
<?php 
    $form=$this->beginWidget('CActiveForm', array(
                'id'=>'question',
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array(
                               //'onsubmit'=>"return false;",// Disable normal form submit 
                               //'onkeypress'=>" if(event.keyCode == 13){ send(); } " //do ajax call when user presses enter key 
                            ),
                'action' => Yii::app()->createUrl('testtree/Ajax', array('userlog_id'=>$userlog_id)),
                ));
    echo $form->errorSummary($model);
    $i = 0;
    //$j = 0;
    $k = 0;
    //$pattern = ' ';
    //$replace = '_';

    foreach($questions as $question)
    {
        echo '<div class="questionblock">';
        echo '<div class="questiontext">';
        echo '<h5> Вопрос №'.($k+1).'</h5>';
        echo '<h5>'.$question->text.'</h5>';
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
                //array_push($parttodisplay,$firstpart);
                //array_push($parttolist,$secondpart);
            }   
        }
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
    /*
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
            //echo '</li>';
            $j++;
        };
        echo '</div>';
        
        
        //echo $form->radioButtonList($model, 'answers['.$j.']',$data);
        //echo '</ul>';
        echo '</div>';
    }*/


    //echo CHtml::Button('SUBMIT',array('onclick'=>'send();')); 
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

<!-- Начало панели счетчика -->
<div id="countdown_dashboard">
    Осталось времени
	<div class="dash hours_dash">
		<span class="dash_title">часов</span>
		<div class="digit">0</div>
		<div class="digit">0</div>
	</div>

	<div class="dash minutes_dash">
		<span class="dash_title">минут</span>
		<div class="digit">0</div>
		<div class="digit">0</div>
	</div>

	<div class="dash seconds_dash">
		<span class="dash_title">секунд</span>
		<div class="digit">0</div>
		<div class="digit">0</div>
	</div>
</div>


<!-- Завершение панели счетчика -->
<script type="text/javascript">
    $(function() {
        var offset = $("#countdown_dashboard").offset();
        var topPadding = 20;
        $(window).scroll(function() {
        if ($(window).scrollTop() > offset.top) {
            $("#countdown_dashboard").stop().animate({marginTop: $(window).scrollTop() - offset.top + topPadding});
        }
        else {$("#countdown_dashboard").stop().animate({marginTop: 0});};});
    });
</script> 

<script language="Javascript" type="text/javascript" src="/js/jquery.lwtCountdown-0.9.5.js"></script>
<script type="text/javascript">
    function send()
    {
            if(document.question.onsubmit &&
            !document.question.onsubmit())
            {
                return;
            }
            document.question.submit();
       //var data=$("#question").serialize();


        //$.ajax({
            //type: 'POST',
            //url: "<? //echo Yii::app()->createUrl('testtree/Ajax', array('userlog_id'=>$userlog_id)); ?>",
            //data:data,
            //success:function(){
                //alert(data); 
              //      },
            //error: function() { // if error occured
                //alert("Error occured.please try again");
                //alert(data);
          //},

        //dataType:'html'
       // });
    }
</script>

<script>
jQuery(document).ready(function() {
	$("#countdown_dashboard").countDown({
		targetOffset: {
			"day": 		0,
			"month": 	0,
			"year": 	0,
			"hour": 	0,
			"min": 		<?php echo $testtreemodel->time?>,
			"sec": 		6
		}, 
		// По завершении счета будет выскальзывать панель #complete_info_message
		onComplete: function(){send();}
	});
});
</script>
<a href="#" onclick="$('#question').submit();return false;">Do it!</a>

