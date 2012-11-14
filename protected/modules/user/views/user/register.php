<?php
	    $this->pageTitle=Yii::app()->name .' -'.UserModule::t("Create New User Account");
?>
<br/>
<br/>
	<div style=" background-color:#FFF; width:100% ">
	<p class="columnheading prepend-1">
		<?php echo UserModule::t($this->pageTitle);?>
	</p>
	<hr/>
		<?php if(Yii::app()->user->hasFlash('registration')): ?>
		<div class="success">
            <?php echo Yii::app()->user->getFlash('registration'); ?>
		</div><!--sucess-->
        <?php endif; ?>
		
			<?php /** @var BootActiveForm $form */
    			$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  			 	'id'=>'horizontalForm',
    			'type'=>'horizontal',

			)); ?>
     <fieldset>
		<div class="prepend-2">
		<p>
					<?php echo UserModule::t("Please fill out the following form to create a new user account:"); ?>
		</p>
		<p>
					<?php echo UserModule::t('Fields with <span class="required">*</span> are Required Fields.'); ?>
		</p>
		</div><!--prepend-2 -->
		<div class="prepend-3">
 					
					<?php echo $form->textFieldRow($profile,'name',array('class'=>'span5')); ?>
					<?php echo $form->textFieldRow($model,'email',array('class'=>'span5')); ?>
     				<?php echo $form->textFieldRow($model,'username',array('class'=>'span5')); ?>
    				<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5')); ?>
    				<?php echo $form->passwordFieldRow($model,'verifyPassword',array('class'=>'span5')); ?>
  					<?php echo $form->dropDownListRow($profile, 'gender', array('Please select', 'Male', 'female')); ?>    
					<div class="control-group" style="padding-left: 70px">
                    <table class="clearfix"><tr ><td >
					<?php echo $form->labelEx($profile,'dob'); ?>
			        </td><td>
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
							array(
								'model'=>$profile,
								'attribute'=>'dob',
								// additional javascript options for the date picker plugin
							    'options'=>array(
							        'showAnim'=>'fold',
									'changeMonth' => true,
									'changeYear' => true,
									'yearRange' =>'1900:'.(date('Y')),
									//'themeUrl'=>'js/jquery-ui-1.8/themes',
      								//'theme'=>'ui-lightness',
									
							    ),
							    'htmlOptions'=>array(
                                	//'class'=>'validate[required, funcCall[checkAge]]',
                                	//'value'=>'Select your Birthday'
                                )
							)); 
						?>
						</td><td>
						<?php echo $form->Error($profile,'dob'); ?>
						</td>
						</tr>
						</table>
						</div><!--control-group-->
     			<p>	
     			<?php echo $form->checkBoxListRow($model, 'Iagree', array('I agree to EazyMaths.com <a>Terms and Conditions</a>')); ?>
                </p>
    			<p>
    			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Create My Account'));?>|<?php echo CHtml::link(UserModule::t("Resend My Email Verification Code"),Yii::app()->getModule('user')->registrationUrl); ?>
    			</p><br/><br/><br/><br/>
                </div><!--prepend-3 -->
                <?php $this->endWidget(); ?>
                </fieldset>
                </div>

			
  	
	
		
		