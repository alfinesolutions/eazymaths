<?php
/**
 * This is the model class for table "{{user}}".
 * The followings are the available columns in table '{{user}}':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $activationkey
 * @property integer $user_type
 * @property integer $status
 * @property string $lastvisit
 * @property string $createdate
 * @property string $updatedate
 */
class UserModel extends CActiveRecord
{
	const STATUS_NOTACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANED=-1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return ((Yii::app()->getModule('user')->isAdmin())?array(
			array('username,  email, password_hash,lastvisit,user_type,status', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols Only Symbols (A-z,0-9) are allowed.")),
			array('status', 'in', 'range'=>array(self::STATUS_NOTACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
			//array('username, email, status, user_type, lastname, firstname', 'safe', 'on'=>'search'),			
			):((Yii::app()->user->id==$this->id)?array(
			array('username, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
		):array()));
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'profiles' => array(self::HAS_ONE, 'ProfileTableModel', 'user_id'),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'username' => 'Username',
				'email' => 'Email',
				'password_hash' => 'Password',
				'activation_key' => 'Activation Key',
				'status' => 'Status',
				'user_type'=>'User Type',
				'lastvisit' => 'Lastvisit',
				'createdat' => 'Createdate',
				'updatedat' => 'Updatedate',
		);
	}
	/**
	 *
	 * Enter description here ...
	 */
	public function scopes()
	{
		return array(
				'active'=>array(
						'condition'=>'status='.self::STATUS_ACTIVE,
				),
				'notactvie'=>array(
						'condition'=>'status='.self::STATUS_NOTACTIVE,
				),
				'banned'=>array(
						'condition'=>'status='.self::STATUS_BANED,
				),
				'user_type'=>array(
						'condition'=>'user_type=1',
				),
				'user'=>array(
						'condition'=>'user_type=0',
				),
				'notsafe'=>array(
						'select' => 'id, username, password_hash, email, activation_key, createdat, lastvisit, status',
				),
		);
	}
	 /**
     * 
     * Enter description here ...
     */
	public function defaultScope()
    {
        return array(
            'select' => 'id, username,  email, createdat, lastvisit, status,user_type',
        );
    }
	
    /**
     * 
     * Enter description here ...
     * @param unknown_type $type
     * @param unknown_type $code
     */
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOTACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $password
	 */
	public function validPassword($password = "") {
		$password_hash = Yii::app()
						->getModule('user')
						->decrypt($password, $this->password_hash);
		if ($password_hash === $this->password_hash)
			return true;
		else 
			return false;
	}
	
}