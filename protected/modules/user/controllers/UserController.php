<?php
class UserController extends Controller
{
	/**
	 * Index action
	 */
	public function actionIndex() {
		/**
		 * If user is Guest Redirct him to login
		 */
		
	if (Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		else{
			$this->redirect(Yii::app()->controller->module->returnUrl);
		}
	}
	/**
	 * Registration of New user
	 */
	public function actionRegister() {
		/**
		 * This controller is for registration of a new user into the database
		 * 
		 * */
		$model=new RegistrationFormModel;
		$profileModel=new ProfileModel;
		$profileModel->regMode = true;		
		if(isset($_POST['RegistrationFormModel']) & isset($_POST['ProfileModel'])) {		
					
				$model->attributes=$_POST['RegistrationFormModel'];
				$profileModel->attributes=$_POST['ProfileModel'];				
				if($model->validate() & $profileModel->validate())
				{	
					$soucePassword = $model->password;
					$model->activation_key = UserModule::encrypting(microtime().$model->password);
					$model->password_hash = UserModule::encrypt($model->password);
					$model->lastvisit=((Yii::app()->controller->module->loginNotActive||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin)?time():0;
					$model->superuser=0;
					$model->status =((Yii::app()->controller->module->activeAfterRegister)?UserModel::STATUS_ACTIVE:UserModel::STATUS_NOTACTIVE);
					
					if ($model->save()) {				
						$profileModel->user_id=$model->id;
						if ($profileModel->save()) {	
						if (Yii::app()->controller->module->sendActivationMail) {
							$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activationkey" => $model->activation_key, "email" => $model->email));
							UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account by going to {activation_url}",array('{activation_url}'=>$activation_url)));
					}
						
					if ((Yii::app()->controller->module->loginNotActive||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
						$identity=new UserIdentity($model->username,$soucePassword);
						$identity->authenticate();
						Yii::app()->user->login($identity,0);
						$this->redirect(Yii::app()->controller->module->returnUrl);
					} else {
						if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
							Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
						} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
							Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
						} elseif(Yii::app()->controller->module->loginNotActive) {
							Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
						} else {
							Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
						}
						$this->refresh();
					}
				}
			} else $profileModel->validate();
		}
		}
		
		$this->render('register',array('model'=>$model,'profile'=>$profileModel));
	
	}
	public function actionLogin() {
	if (Yii::app()->user->isGuest) {
		$model=new LoginFormModel;
		// collect user input data
		if(isset($_POST['LoginFormModel'])){									
			$model->attributes=$_POST['LoginFormModel'];
			if($model->validate()) {
							
				$this->lastVisit();
				if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
					$this->redirect(Yii::app()->controller->module->returnUrl);
				else
					$this->redirect(Yii::app()->user->returnUrl);
			}	
			
					
		}		
			$this->render('login',array('model'=>$model));		
	}
	else{
		$this->redirect(Yii::app()->user->returnUrl);
	}		
	}
	private function lastVisit() {
		$lastVisit = UserModel::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = new CDbExpression('NOW()');
		$lastVisit->save();
	}
	
	
	public function actionUserAccontRecover() {
		$form = new UserAccontRecoverFormModel;
		if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
				$email = ((isset($_GET['email']))?$_GET['email']:'');
				$activationkey = ((isset($_GET['activationkey']))?$_GET['activationkey']:'');
				if ($email&&$activationkey) {
					$form2 = new UserChangePassword;
		    		$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
		    		if(isset($find)&&$find->activationkey==$activkey) {
			    		if(isset($_POST['UserChangePassword'])) {
							$form2->attributes=$_POST['UserChangePassword'];
							if($form2->validate()) {
								$find->password = Yii::app()->controller->module->encrypt($form2->password);
								$find->activationkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
								if ($find->status==0) {
									$find->status = 1;
								}
								$find->save();
								Yii::app()->user->setFlash('recoveryMessage',UserModule::t("New password is saved."));
								$this->redirect(Yii::app()->controller->module->recoveryUrl);
							}
						} 
						$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserAccontRecoverFormModel'])) {
			    		$form->attributes=$_POST['UserAccontRecoverFormModel'];
			    		if($form->validate()) {
			    			$user = UserModel::model()->notsafe()->findbyPk($form->user_id);
							$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activationkey" => $user->activation_key, "email" => $user->email));
							
							$subject = UserModule::t("You have requested the password recovery site {site_name}",
			    					array(
			    						'{site_name}'=>Yii::app()->name,
			    					));
			    			$message = UserModule::t("You have requested the password recovery site {site_name}. To receive a new password, go to {activation_url}.",
			    					array(
			    						'{site_name}'=>Yii::app()->name,
			    						'{activation_url}'=>$activation_url,
			    					));
							
			    			UserModule::sendMail($user->email,$subject,$message);
			    			
							Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Please check your email. An instructions was sent to your email address."));
			    			$this->refresh();
			    		}
			    	}
		    		$this->render('accountrecover',array('model'=>$form));
		    	}
		    }
	}
}
