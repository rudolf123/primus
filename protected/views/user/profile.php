<div id="content">
<h3>Пользователь: <?php echo Yii::app()->user->name; ?></h3>
<h4>Статус: <?php if (Yii::app()->user->checkAccess('moderator'))
                      echo 'Преподаватель';
                  else 
                      echo 'Обучаемый';?></h4>
<?php
$ss = $model->learningtime;
$s = $ss%60;
$m = floor(($ss%3600)/60);
$h = floor(($ss%86400)/3600);
$d = floor(($ss%2592000)/86400);

echo  "Время работы:  $d дн., $h ч., $m мин., $s сек.";
?>

<?php 
if (Yii::app()->user->checkAccess('moderator'))
{
    $dataProvider = new CActiveDataProvider('User');//, array(
                      //  'criteria' => array(
                      //  'condition' => 'question_id = :id_q',
                       // 'params' => array(':id_q' => $model->id),
                       // ),
   // ));
    $this->widget('bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', // 'tabs' or 'pills'
        'tabs'=>array(
                array('label'=>'Home', 'content'=>$this->renderPartial('usersView',array('dataProvider' => $dataProvider),true), 'active'=>true),
                array('label'=>'Profile', 'content'=>'Profile Content'),
                array('label'=>'Messages', 'content'=>'Messages Content'),
            ),
        ));
    //$this->renderPartial('usersView',null,true);
    $this->widget('zii.widgets.jui.CJuiAccordion', array(
        'panels'=>array(
        'panel 1'=>'content for panel 1',
        'panel 2'=>$this->renderPartial('usersView',array('dataProvider' => $dataProvider),true),
        // panel 3 contains the content rendered by a partial view
        // 'panel 3'=>$this->renderPartial('_partial',null,true),
        ),
        // additional javascript options for the accordion plugin
        'options'=>array(
        'animated'=>'bounceslide',
        ),
    ));
        

}
?>
</div>

<script>
        $(document).ready(function(){
            function timer()
            {
                $.ajax({
                        type: "POST",
                        url:    "<? echo Yii::app()->createUrl('helptree/keepAliveStatus'); ?>",
                        data:  {val1:1,val2:2},
                        success: function(){
                             //alert("Sucess");
                            },
                        error: function(){
                        //alert("failure");

                        }
                      });
            }
            setInterval(timer,60000);
        });
</script>