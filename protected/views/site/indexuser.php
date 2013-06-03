<?php $this->pageTitle=Yii::app()->name; ?>

<?php
    $this->widget('bootstrap.widgets.TbCarousel', array(
    'items'=>array(
        array(
        'image'=>'/storage/tutorial_1.jpg',
        'label'=>'Регистрация',
        'caption'=>' '
        //'Donec id elit non mi porta gravida at eget metus. ' .
        //'Nullam id dolor id nibh ultricies vehicula ut id elit.'
        ),
        array(
        'image'=>'/storage/tutorial_2.jpg',
        'label'=>'Вход',
        'caption'=>' '
        //'Donec id elit non mi porta gravida at eget metus. ' .
        //'Nullam id dolor id nibh ultricies vehicula ut id elit.'
        ),
        array(
        'image'=>'/storage/tutorial_3.jpg',
        'label'=>'Работа с системой',
        'caption'=>' '
        //'Donec id elit non mi porta gravida at eget metus. ' .
        //'Nullam id dolor id nibh ultricies vehicula ut id elit.',
        //    'imageOptions'=>array(
        //'style'=>'margin: 10px; width:400px; ',
        //),
        ),
        
        ),

    ));
    
?>