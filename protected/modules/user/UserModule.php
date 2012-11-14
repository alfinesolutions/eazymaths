<?php

class UserModule extends CWebModule
{
	
	/**
	 * @var string
	 * @desc hash method (md5,sha1 or algo hash function http://www.php.net/manual/en/function.hash.php)
	 */
	public $hash='md5';
	

	
	/**
	 * @var boolean
	 * @desc use email for activation user account
	 */
	public $sendActivationMail=true;
	
	/**
	 * @var boolean
	 * @desc allow auth for is not active user
	 */
	public $loginNotActive=false;
	
	/**
	 * @var boolean
	 * @desc activate user on registration (only $sendActivationMail = false)
	 */
	public $activeAfterRegister=false;
	
	
	static private $_user;
	static private $_admin;
	
	public $registrationUrl = array("/user/user/register");
	public $loginUrl = array("/user/user/login");
	public $logoutUrl = array("/user/logout");
	public $recoveryUrl = array("/user/user/recovery/");
	public $returnUrl = array("/site/index");
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	/**
	 * @param $str
	 * @param $params
	 * @param $dic
	 * @return string
	 */
	public static function t($str='',$params=array(),$dic='user') {
		return Yii::t("UserModule.".$dic, $str, $params);
	}
	
	/**
	 * @return hash string.
	 */
	public static function encrypting($string="") {
		$hash = Yii::app()->getModule('user')->hash;
		if ($hash=="md5")
			return md5($string);
		if ($hash=="sha1")
			return sha1($string);
		else
			return hash($hash,$string);
	}
	
	/**
	 * @return hash string.
	 */
	public static function encrypt($string="") {
		return crypt($string, Randomness::blowfishSalt());
	}
	/**
	 * @return hash string.
	 */
	public static function decrypt($string="", $hash) {
		return crypt($string, $hash);
	}
		/**
	 * Send mail method
	 */
	public static function sendMail($email,$subject,$message) {
		$adminEmail = Yii::app()->params['adminEmail'];
		$headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
		$body_top='<!DOCTYPE html>
<html lang="en"><head>
<style>
body {
      padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
}
.well {
  	min-height: 20px;
  	padding: 19px;
  	margin-bottom: 20px;
 	background-color: #f5f5f5;
  	border: 1px solid #e3e3e3;
  	-webkit-border-radius: 4px;
    -moz-border-radius: 4px;
        border-radius: 4px;
  	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
	}
	a{
		color:#39F;
		text-decoration:none;
	}
	a:focus {
  		outline: thin dotted #333;
  		outline: 5px auto -webkit-focus-ring-color;
  		outline-offset: -2px;
	}

	a:hover,
	a:active {
		color:#C00;
  		outline: 0;
	}

    </style>
    

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body><!-- /container -->
  <div class="well">
  <a href="http://www.eventskerala.com/eazymaths/"><h1>EazyMaths.com</h1></a><hr>';
    $body_bottom='
    <p>Thank you </p>
    <p>Web Master</p>
    <p><a href="http://www.eventskerala.com/eazymaths/">Eazy Maths.com</a></p>
    <p>&nbsp;</p>
  </div>

</body></html>';
		$message = wordwrap($message, 70);
		$final_message=$body_top.$message.$body_bottom;
		$final_message= str_replace("\n.", "\n..", $final_message);
		return mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$final_message,$headers);
	}
	
	/**
	 * Return admin status.
	 * @return boolean
	 */
	public static function isAdmin() {
		if(Yii::app()->user->isGuest)
			return false;
		else {
			if (!isset(self::$_admin)) {
				if(self::user()->user_type)
					self::$_admin = true;
				else
					self::$_admin = false;
			}
			return self::$_admin;
		}
	}
	
	
			/**
	 * Return safe user data.
	 * @param user id not required
	 * @return user object or false
	 */
	public static function user($id=0) {
		if ($id) 
			return UserModel::model()->active()->findbyPk($id);
		else {
			if(Yii::app()->user->isGuest) {
				return false;
			} else {
				if (!self::$_user)
					self::$_user = UserModel::model()->active()->findbyPk(Yii::app()->user->id);
				return self::$_user;
			}
		}
	}
}
