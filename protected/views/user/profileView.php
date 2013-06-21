<div id="block" class="well">
<h5>
<?php
/*$arr_data = array('Фамилия: '=>$model->surname,
                    'Имя: '=>$model->name,
                    'Отчество: '=>$model->secondname,
                    'Звание: '=>$model->rank,
                    'Подразделение: '=>$model->block,
                    'Зарегистрирован: '=>$model->regdate,
    );*/
echo 'Фамилия: '.$model->surname.'<br />';
echo 'Имя: '.$model->name.'<br />';
echo 'Отчество: '.$model->secondname.'<br />';
echo 'Звание: '.$model->rank.'<br />';
echo 'Подразделение: '.$model->block.'<br />';
echo 'Зарегистрирован: '.$model->regdate.'<br />';
echo 'Статус: ';
if (Yii::app()->user->checkAccess('moderator'))
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
</div>