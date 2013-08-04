<?php

echo CHtml::link('Список званий для анкеты', Yii::app()->createUrl('rank/admin'));
echo '<br />';
echo CHtml::link('Список подразделений для анкеты', Yii::app()->createUrl('block/admin'));
echo '<br />';
echo CHtml::link('Материалы информационной справки и обучения',  Yii::app()->createUrl('site/Adminsections'));
echo '<br />';
if (System::model()->findByAttributes(array('id'=>1))->value==="yes")
    echo CHtml::link('Запретить просмотр результатов самоконтроля',  Yii::app()->createUrl('site/admin', array('enable_results'=>0, 'backurl'=>Yii::app()->request->url)));  
else
    echo CHtml::link('Разрешить просмотр результатов самоконтроля',  Yii::app()->createUrl('site/admin', array('enable_results'=>1, 'backurl'=>Yii::app()->request->url)));   
?>
