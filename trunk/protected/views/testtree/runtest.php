<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'question',
    'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
                               'onsubmit'=>"return false;",/* Disable normal form submit */
                               'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
                             ),
)); ?>
 
 
    <?php echo $form->errorSummary($model); ?>
 
    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
        <div class="row">
        <?php echo $form->labelEx($model,'age'); ?>
        <?php echo $form->textField($model,'age'); ?>
        <?php echo $form->error($model,'age'); ?>
    </div>
 
 
    <div class="row buttons">
        <?php echo CHtml::Button('SUBMIT',array('onclick'=>'send();')); ?> 
    </div>
 
<?php $this->endWidget(); ?>


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
   
    <?php
    //$answers = Answer::model()->findAllByAttributes(array('question_id'=>$question->id));
    foreach($arr_answers[$i++] as $answer)
    {
        echo '<br/>';
        echo $answer;
    }
    ?>
    <form id="questionBox" method="post" action="test.php">
    <ul>
    </ul>
    <p><input type="hidden" name="num" value="" />
    <input type="hidden" name="submitter" value="TRUE" />
    <input type="submit" id="submit" name="submit" value="Submit Answer" /></p>
    </form>
<?php } ?>
    
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
