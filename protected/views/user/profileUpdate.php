<div id="content">
<?php>
        $forms = $this->beginWidget('CActiveForm', array(
                'id' => 'adduser-form',
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true, // <<<<------ валидация по AJAX
                'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                    ),
                'htmlOptions'=>array(
                    'class'=>'well',
                    'accept-charset'=>'UTF-8',
                ),
                'action' => array('user/update'), // когда форма показывается и в других контроллерах, не только 'site', то я в каждый из этих контроллеров вставил actionQuick, a здесь указал — array('quick'); почему-то не получается с array('//site/quick')

            ));
?>
<?php echo $forms->errorSummary($model); ?><br />
    <table id="form2" border="0" width="400" cellpadding="10" cellspacing="10">
         <tr>
            <!-- Выводим поле для фамилии !-->
            <td width="150"><?php echo $forms->labelEx($model, 'surname'); ?></td>
            <td><?php echo $forms->textField($model, 'surname') ?></td>
         </tr>
        <tr>
            <!-- Выводим поле для имени !-->
            <td><?php echo $forms->labelEx($model, 'name'); ?></td>
            <td><?php echo $forms->textField($model, 'name') ?></td>
         </tr>
         <tr>
            <!-- Выводим поле для отчества !-->
            <td><?php echo $forms->labelEx($model, 'secondname'); ?></td>
            <td><?php echo $forms->textField($model, 'secondname') ?></td>
         </tr>
                  <tr>
            <!-- Выводим поле для звания !-->
            <td><?php echo $forms->labelEx($model, 'rank'); ?></td>
            <td><?php echo $forms->dropDownList($model,'rank',CHtml::listData(Rank::model()->findAll(),
                                                    'id','name'),
                                                    array('empty' => 'Без звания','style'=>'width: 215px')); ?>
            </td>
         </tr>
                  <tr>
            <!-- Выводим поле для подразделения !-->
            <td><?php echo $forms->labelEx($model, 'block'); ?></td>
            <td><?php echo $forms->dropDownList($model,'block',CHtml::listData(Block::model()->findAll(),
                                                    'id','name'),
                                                    array('empty' => 'Без подразделения','style'=>'width: 215px')); ?></td>
         </tr>
         <!-- Выводим поле для пароля !-->
         <tr>
            <td><?php echo $forms->labelEx($model, 'passwd'); ?></td>
            <td><?php echo $forms->passwordField($model, 'passwd') ?></td>
            <td><?php echo $forms->error($model,'passwd'); ?></td>
         </tr>

         
        <tr>
            <td></td>
            <!-- Кнопка "регистрация" !-->
             <td class="button_box">
                 <?php $this->widget('zii.widgets.jui.CJuiButton', array(
                            'name'=>'buttonSubmit',
                            'caption'=>'Сохранить изменения',
                            'htmlOptions'=>array(
                                'style'=>'height:40px; width:215px;',
                                'class'=>'ui-button-primary'
                                ),
                            'onclick'=>'submit',
                            )
                        ); ?>
             </td>
        </tr>
    </table>

<!-- Закрываем форму !-->
        <?php $this->endWidget(); ?>
</div>