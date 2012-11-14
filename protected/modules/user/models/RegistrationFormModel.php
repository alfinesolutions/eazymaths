<?php
	class RegistrationFormModel extends UserModel {
	public $password;
	public $verifyPassword;
	public $verifyCode;
	public $Iagree;
	public $activationkey;
	public $superuser;
	
	public function rules() {
		$rules = array(
				array('username, password, verifyPassword, email', 'required'),
				array('Iagree', 'compare', 'compareValue' => true, 'message' => UserModule::t("You must agree to the terms and conditions") ),
				array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
				array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
				array('email', 'email','allowEmpty'=>'false', ),
				array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
				array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
				array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
				array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z 0-9) are only allowed.")),
		);
		//if (isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		//	return $rules;
		//else
		//	array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		return $rules;
	}
	public function attributeLabels()
	{
		return array(
				'Iagree' => '',
				'verifyPassword'=>'Verify Password',
				'username' => 'Username',
				'email' => 'Email',
				'password' => 'Password',
				'activation_key'=> '',
				
	
		);
	}
}