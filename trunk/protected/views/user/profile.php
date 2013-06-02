<div id="content">
<h1>Пользователь: <?php echo Yii::app()->user->name; ?></h1>
<h2>Статус: <?php if (Yii::app()->user->checkAccess('moderator'))
                      echo 'Преподаватель';
                  else 
                      echo 'Обучаемый';?></h2>
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
                array('label'=>'Home', 'content'=>'Home Content', 'active'=>true),
                array('label'=>'Profile', 'content'=>'Profile Content'),
                array('label'=>'Messages', 'content'=>'Messages Content'),
            ),
        ));
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'aswer-grid',
    'dataProvider'=>$dataProvider,
    //'filter'=>$dataProvider,
    'columns'=>array(
            'surname',
            'name',
            'secondname',
            'block',
            'rank',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{delete}',
                //'viewButtonUrl' => 'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                //'deleteButtonUrl'=> 'Yii::app()->createUrl("question/deleteAnswer", array("id"=>$data->id))',
                /*'buttons'=>array
                (
                    'view' => array
                    (
                        'label'=>'Просмотреть ответ',
                        'url'=>'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                    ),
                    'update' => array
                    (
                        'label'=>'Изменить ответ',
                        'url'=>'Yii::app()->createUrl("question/viewAnswer", array("id"=>$data->id))',
                    ),
                ),*/

            ),
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