<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/lightbox.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->
        <div id="mainmenu">

		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Главная', 'url'=>array('/site/index')),
				array('label'=>'Информационная справка', 'url'=>array('/helptree/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Обучение', 'url'=>array('/trainingtree/index'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Проверка знаний', 'url'=>array('/testtree/index'), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Регистрация', 'url'=>array('user/registration'), 'visible'=>Yii::app()->user->isGuest),
                            	array('label'=>'Вход', 'url'=>array('user/login'), 'visible'=>Yii::app()->user->isGuest),
                                array('label'=>'Банк вопросов', 'url'=>array('question/admin'), 'visible'=>!Yii::app()->user->isGuest&&Yii::app()->user->checkAccess('moderator')),
                                array('label'=>'Администрирование', 'url'=>array('site/admin'), 'visible'=>!Yii::app()->user->isGuest&&Yii::app()->user->checkAccess('moderator')),
                                array('label'=>'Выход', 'url'=>array('user/logout'), 'visible'=>!Yii::app()->user->isGuest, 'itemOptions'=>array('class'=>'menuleft')),    
                                array('label'=>'Личный кабинет', 'url'=>array('user/profile'), 'visible'=>!Yii::app()->user->isGuest,'itemOptions'=>array('class'=>'menuleft')),



			),
                    )); 
                    /*    $this->widget('MyTbNavbar', array(
                                'brand' => '',
                                //'type'=>'inverse',
                                'htmlOptions'=>array('style'=>'position: relative; background: #EFEFEF;',
                                                     ),
                                'items' => array(

                                        array(
                                                'class' => 'bootstrap.widgets.TbMenu',
                                                'type'=>'pills',
                                                'items' => array(
                                                    
                                                        array('label'=>'Главная', 'url'=>array('/site/index'), ),
                                                        array('label'=>'Информационная справка', 'url'=>array('/helptree/index'), 'visible'=>!Yii::app()->user->isGuest),
                                                        array('label'=>'Обучение', 'url'=>array('/trainingtree/index'), 'visible'=>!Yii::app()->user->isGuest),
                                                        array('label'=>'Проверка знаний', 'url'=>array('/testtree/index'), 'visible'=>!Yii::app()->user->isGuest),
                                                        array('label'=>'Регистрация', 'url'=>array('user/registration'), 'visible'=>Yii::app()->user->isGuest),
                                                        array('label'=>'Вход', 'url'=>array('user/login'), 'visible'=>Yii::app()->user->isGuest),
                                                        array('label'=>'Банк вопросов', 'url'=>array('question/admin'), 'visible'=>!Yii::app()->user->isGuest&&Yii::app()->user->checkAccess('moderator')),
                                                        array('label'=>'Личный кабинет', 'url'=>array('user/profile'), 'visible'=>!Yii::app()->user->isGuest),
                                                        array('label'=>'Выход', 'url'=>array('user/logout'), 'visible'=>!Yii::app()->user->isGuest),
                                                ),
                                            )
                                    )
                            ));*/
                
                ?>
	</div><!-- mainmenu -->
        
        <div id="usernamebar">
            <?php if (!Yii::app()->user->isGuest) echo 'Добро пожаловать: '.Yii::app()->user->name ?>
        </div>
        
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
        <div id="scrollupbutton" class="scroll-to-top-button"></div>
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Программирование: Юранов В.С.: rudolf123@narod.ru &copy <?php echo date('Y'); ?> .<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

<script src="/js/lightbox.js"></script>

<script>
(function(jq) {
	jq.autoScroll = function(ops) {
		ops = ops || {};
		ops.styleClass = ops.styleClass || 'scroll-to-top-button';
		var t = jq('<div class="'+ops.styleClass+'"></div>'),
    	d = jq(ops.target || document);
		jq(ops.container || 'body').append(t);

		t.css({
			opacity: 0,
			position: 'absolute',
			top: 0,
			right: 0
		}).click(function() {
		jq('html,body').animate({
			scrollTop: 0
		}, ops.scrollDuration || 1000);
	});

	d.scroll(function() {
		var sv = d.scrollTop();
		if (sv < 1000) {
			t.clearQueue().fadeOut(ops.hideDuration || 200);
			return;
		}

		t.css('display', '').clearQueue().animate({
			top: sv,
			opacity: 0.8
		}, ops.showDuration || 500);
		});
	};
})(jQuery);

$(document).ready(function(){
	$.autoScroll({
		scrollDuration: 1000, 
		showDuration: 600, 
		hideDuration: 300
	});
});
</script>

</body>
</html>
