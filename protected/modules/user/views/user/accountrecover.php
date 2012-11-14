<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore User Account");
?>
<!-- Content -->
	<legend>
		<?php echo Yii::app()->name .' -'.UserModule::t("Restore User Account"); ?>
	</legend>
<div class="inner-box-half">
	<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
	<div class="success">
		<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
	</div>
	<?php endif; ?>
	<?php //else: ?>
	<div class="changepass-form-outer">
		<div class="form">
			<?php /** @var BootActiveForm $form */
				$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    			'id'=>'horizontalForm',
    			'type'=>'horizontal',
				)); ?>
 			<?php echo $form->textFieldRow($model, 'login_or_email', array('class'=>'span3')); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Restore','type'=>'primary')); ?>
 			<?php $this->endWidget(); ?>
		</div>
		<!-- form -->
	<?php //endif; ?>
	</div>
</div>


