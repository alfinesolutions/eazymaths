<?php
    $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
?>
<br/>
<br/>

<div style=" background-color:#FFF; width:100% ">
<fieldset>
<br/>
<?php /** @var BootActiveForm $form */
    	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'horizontalForm',
    	'type'=>'horizontal',
	)); ?>
<p class="columnheading prepend-1"><?php echo UserModule::t($this->pageTitle); ?></p>
<hr/>
<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
        <div class="alert alert-error">
            <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
        </div>
<?php endif;?>  
	 <div class="prepend-2">
		<p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>
		<p><?php echo UserModule::t('Fields with <span class="required">*</span> are Required Fields.'); ?></p>
	 </div>
 	 <div class="prepend-3">
 	 	<?php if($model->hasErrors('status')){ ?>
 		<div class="alert alert-error">	
 			<?php echo $form->Error($model, 'status'); ?>
 		</div>
 		<?php } ?>
     	<?php echo $form->textFieldRow($model,'username',array('class'=>'span4')); ?>
    	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span4')); ?>
    	<?php echo $form->checkboxRow($model,'rememberMe'); ?>
		<p class="hint">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Login')); ?>		| 
		<?php echo CHtml::link(UserModule::t("Create a New Account"),Yii::app()->getModule('user')->registrationUrl); ?>
        </p>
        <p>
         <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
	</div>
<br/>
</fieldset>
<br/><br/>
<?php $this->endWidget(); ?>
</div>

