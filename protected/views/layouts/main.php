<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" media="screen, projection" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family:Open Sans,sans-serif;
	font-size: 18px;
	
	background-image:url(images/banner.jpg);
	
    background-position:center;
	background-repeat:no-repeat;
	background-attachment:fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	
	a:link {background-color:#B2FF99;}
	a:visited {background-color:#FFFF85;}
	a:hover {background-color:#FF704D;}
	a:active {background-color:#FF704D;}
}
.subcolumnheading {
	color: #10ace7;
	font-weight: bold;
	font-family: "Open Sans";
	font-size:20px;
	padding:10px;
}
.subcolumncontent {
	font-family: "Open Sans";
	padding-left:25px;
	padding-right:25px;
	padding-bottom:30px;
}
.columncontent {
	font-family: "Open Sans";
	padding-bottom:20px;
}
.columnheading {
	color: #10ace7;
	font-family:"Open Sans",serif; 
	font-weight:500px; 
	font-size:30px;
	padding-top:25px;
}
.jquery{
	width:1024;
	height:450px;
	margin:0 auto;
	
}
.wrappercenter{
	width:100%;
	height:auto;
	background: url(images/pattern.png) repeat scroll center center rgb(238, 238, 238);
}
#footerwrapper{
	width:100%;
	height:150px;
	background: url(images/footer.jpg) repeat scroll center center rgb(238, 238, 238);
}
#footer{
	width:1024px;
	height:150px;
	margin:0 auto;
}
#footer a {
	color: #FFFFFF;
	text-decoration: none;
}
#footer a:hover {
	color: #10ace7;
}

</style>
    
    
</head>

<body>


	
	<?php 
	$this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>'EazyMaths.com',
    'brandUrl'=>'',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>'', 'active'=>true),
                array('label'=>'About Us', 'url'=>'#'),
                array('label'=>'Business', 'url'=>'#'),
                array('label'=>'Product', 'url'=>'#'),
                array('label'=>'Contact Us', 'url'=>array('/site/contact')),
			),
            ),
			array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Sign In', 'url'=>array('/user/'),'visible'=>Yii::app()->user->isGuest),
                array('label'=>Yii::app()->user->name,'visible'=>!(Yii::app()->user->isGuest),'url'=>'#','items'=>array(
                	array('label'=>'Logout','url'=>array('/site/logout')), 
					array('label'=>'Settings','url'=>'#'),
					array('label'=>'Edit Account','url'=>'#'),
				)
					
            ),
       
        ),
        ),
         
	
	))); ?>			
	<!-- mainmenu -->
 	
    
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	
	<?php echo $content; ?>
	
<footer id="footerwrapper">

</footer>
</body>
</html>
