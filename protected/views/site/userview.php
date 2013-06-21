<h4>Просмотр профиля пользователя: <?php echo $model->login?></h4>  
<div id="block" class="well">
  
<h5>
<?php
echo 'Фамилия: '.$model->surname.'<br />';
echo 'Имя: '.$model->name.'<br />';
echo 'Отчество: '.$model->secondname.'<br />';
echo 'Звание: '.$model->rank.'<br />';
echo 'Подразделение: '.$model->block.'<br />';
echo 'Зарегистрирован: '.$model->regdate.'<br />';
echo 'Статус: ';
if ($model->role == 'moderator')
                      echo 'Преподаватель'.'<br />';
                  else 
                      echo 'Обучаемый'.'<br />';
echo 'Имя пользователя: '.$model->login.'<br />';


$ss = $model->learningtime;
$s = $ss%60;
$m = floor(($ss%3600)/60);
$h = floor(($ss%86400)/3600);
$d = floor(($ss%2592000)/86400);

echo  "Время работы:  $d дн., $h ч., $m мин., $s сек.";
?>
</h5>
<div>
<?php
if ($model->role == 'user')
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonAddMaterial',
            'caption'=>'Сделать преподавателем',
            'buttonType'=>'link',
            'htmlOptions'=>array(
                'class'=>'ui-button-primary',
                ),
            'url'=>Yii::app()->createUrl('site/makemoderator',array('id'=>$model->id)),
            )
        );

if ($model->role == 'moderator')
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonAddMaterial',
            'caption'=>'Сделать обучаемым',
            'buttonType'=>'link',
            'htmlOptions'=>array(
                'class'=>'ui-button-primary',
                ),
            'url'=>Yii::app()->createUrl('site/makemoderator',array('id'=>$model->id)),
            )
        );
?>
</div>
</div>
