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
    $k = 0;

    shuffle($questions);
    
    $tempquestions = array();
    $ordredquestions = array();
    $counter_oq = 0;
    foreach ($questions as $question)
    {
        $tempquestions[$counter_oq] = $question;
        ++$counter_oq;
    }
    $i = 0;
    $j = 0;
    for($i=1;$i<$counter_oq;$i++)
        for ($j=0;$j<$counter_oq-$i;$j++)
            if ($tempquestions[$j]->rate>$tempquestions[$j+1]->rate)
            {
                    $t=$tempquestions[$j];
                    $tempquestions[$j]=$tempquestions[$j+1];
                    $tempquestions[$j+1]=$t;
            }

    foreach($tempquestions as $question)
    {
        echo '<div class="questionblock">';
        echo '<div class="questiontext">';
        echo '<h5> Вопрос № '.($k+1).'</h5>';
        echo '<h5> Сложность: '.$question->rate.'</h5>';
        echo '<h5>'.$question->text.'</h5>';
        echo '</div>';
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
