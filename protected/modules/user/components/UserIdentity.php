<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIVE=4;
	const ERROR_STATUS_BANED=5;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		if (strpos($this->username,"@")) {
			$user=UserModel::model()->notsafe()->findByAttributes(array('email'=>$this->username));
		} else {
			$user=UserModel::model()->notsafe()->findByAttributes(array('username'=>$this->username));
		}
		
			if($user===null)
				if (strpos($this->username,"@")) {
					$this->errorCode=self::ERROR_EMAIL_INVALID;
				} 
				else {
					$this->errorCode=self::ERROR_USERNAME_INVALID;
				}
			
			else if(!$user->validPassword($this->password))
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			else if($user->status==0&&Yii::app()->getModule('user')->loginNotActive==false)
				$this->errorCode=self::ERROR_STATUS_NOTACTIVE;
			else if($user->status==-1)
				$this->errorCode=self::ERROR_STATUS_BANED;
			else {
				$profile=ProfileModel::model()->findByAttributes(array('user_id'=>$user->id));
				$this->_id=$user->id;
				$this->username=$user->username;
				$this->setState('lastLoginTime', $user->lastvisit);
				$roles = $user->user_type ? 'admin' : 'user';
				$this->setState('roles', $roles); 
				if($profile !== null) {
					$this->setState('name', $profile->name);
				}
				$this->errorCode=self::ERROR_NONE;
			}
			
		return !$this->errorCode;
	}
    
    /**
    * @return integer the ID of the user record
    */
	public function getId()
	{
		return $this->_id;
	}
}