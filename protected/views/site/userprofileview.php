<div id="block" class="well">
  
<?php
$rank = Rank::model()->findByPk($model->rank)->name;
if (!$rank)
    $rank = 'Нет звания';
$block = Block::model()->findByPk($model->block)->name;
if (!$block)
    $block = 'Нет подразделения';
$role = '';
if ($model->role == 'moderator')
    $role = 'Преподаватель';
else 
    $role = 'Обучаемый';

$ss = $model->learningtime;
$s = $ss%60;
$m = floor(($ss%3600)/60);
$h = floor(($ss%86400)/3600);
$d = floor(($ss%2592000)/86400);

$ss = $d." дн., ".$h." ч., ".$m." мин., ".$s." сек.";

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'surname',
		'name',
		'secondname',
                array(
                    'name'=>'rank',
                    'value' => $rank,
                ),
                array(
                    'name'=>'block',
                    'value' => $block,
                ),
                'regdate',
                'login',
                array(
                    'name'=>'role',
                    'value' => $role,
                ),
                array(
                    'name'=>'learningtime',
                    'value' => $ss,
                ),
	),
));
?>
<div class="button_box">
<?php
/*if ($model->role == 'user')
        $this->widget('zii.widgets.jui.CJuiButton', array(
            'name'=>'buttonAddMaterial',
            'caption'=>'Сделать преподавателем',
            'buttonType'=>'link',
            'htmlOptions'=>array(
                //'class'=>'ui-button-primary',
                ),
            'url'=>Yii::app()->createUrl('site/makemoderator',array('id'=>$model->id)),
            )
        );*/

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
