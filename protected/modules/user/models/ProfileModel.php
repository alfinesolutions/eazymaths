<?php
/**
 * This is the model class for table "{{profile}}".
 * The followings are the available columns in table '{{profile}}':
 * @property int $id
 * @property int $user_id
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $dob
 * @property string $gender
 * @property string $mobile
 * @property string $landline
 * @property string $street_address
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $postcode
 * @property string $createdate
 * @property string $updatedate
 * @property string $avator
 */
class ProfileModel extends CActiveRecord
{
	public $regMode = false;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Profile the static model class
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
		return '{{profile}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('name, dob, gender,','required'),
				array('user_id', 'length', 'max'=>20),
				array('name, street_address, city, state, country, avator', 'length', 'max'=>256),
				array('gender', 'length', 'max'=>8),
				array('gender', 'custom_rule'),
				//array('dob, updatedate', 'custom_rule'),
				array('mobile, landline, postcode', 'length', 'max'=>16),
				array('dob, updatedate', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, user_id,name, dob, gender, mobile, landline, street_address, city, state, country, postcode, createdate, updatedate, avator', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		/*return array(
				'user' => array(self::BELONGS_TO, 'UserTableModel', 'user_id'),
				
		);*/
		$relations = array(
			'user'=>array(self::HAS_ONE, 'UserModel', 'id'),
		);
		if (isset(Yii::app()->getModule('user')->profileRelations)) $relations = array_merge($relations,Yii::app()->getModule('user')->profileRelations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'user_id' => 'User',
				'name' => 'Name',
				'dob' => 'Date of Birth',
				'gender' => 'Gender',
				'mobile' => 'Mobile Number',
				'landline' => 'Landline Number',
				'street_address' => 'Street Address',
				'city' => 'City',
				'state' => 'State',
				'country' => 'Country',
				'postcode' => 'Postal Code',
				'createdate' => 'Createdate',
				'updatedate' => 'Updatedate',
				'avator' => 'Upload Your Avator',
		);
	}
	
	
	/**
	 * This function validate check box
	 */
	public function custom_rule()//$attribute,$params)
	{
		if($this->gender==0){
			$this->addError("gender","Please select a Value");
		}
		//if($this->dob===null){
	//		$this->addError("dob","Please select a Value");
		//}
	}
	
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('middlename',$this->middlename,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('landline',$this->landline,true);
		$criteria->compare('street_address',$this->street_address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('createdate',$this->createdate,true);
		$criteria->compare('updatedate',$this->updatedate,true);
		$criteria->compare('avator',$this->avator,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}