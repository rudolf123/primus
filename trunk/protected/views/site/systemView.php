<?php

echo CHtml::link('Список званий для анкеты', Yii::app()->createUrl('rank/admin'));
echo '<br />';
echo CHtml::link('Список подразделений для анкеты', Yii::app()->createUrl('block/admin'));
echo '<br />';
echo CHtml::link('Материалы информационной справки и обучения',  Yii::app()->createUrl('site/Adminsections'));
echo '<br />';
   
?>
