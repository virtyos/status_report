<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $login
 * @property string $password_hash
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $avatar_id
 * @property string $auth_token
 * @property integer $auth_token_expires
 * @property integer $timezone
 *
 * The followings are the available model relations:
 * @property Report[] $reports
 * @property Image $avatar
 */
class User extends CActiveRecord
{

  public $new_password = '';
  public $new_password_confirm = '';
  
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, first_name, last_name', 'required'),
      array('login', 'isLoginExist', 'on' => 'add, edit'),
			array('created_at, updated_at, avatar_id, auth_token_expires', 'numerical', 'integerOnly'=>true),
			array('login', 'length', 'max'=>100),
			array('password_hash, auth_token_expires', 'length', 'max'=>32),
      array('new_password', 'correctConfirm', 'on' => 'edit, add'),
      array('new_password', 'required', 'on' => 'add'),
			array('first_name, last_name', 'length', 'max'=>150),
			array('role', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, password_hash, first_name, last_name, role, created_at, updated_at, avatar_id, auth_token, auth_token_expires', 'safe', 'on'=>'search'),
		);
	}
  
  public function correctConfirm() {
    if ($this->new_password != $this->new_password_confirm) {
      $this->addError('new_password', 'Пароль и подтверждение не совпадают');
      return false;
    }
    return true;
  }
  
  public function isLoginExist() {
    $anotherUser = $this->find('login = :login', array(':login' => $this->login));
    if ($anotherUser) {
      $this->addError('new_password', 'Такой логин уже занят');
      return false;
    }
  }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'reports' => array(self::HAS_MANY, 'Report', 'owner_id'),
			'avatar' => array(self::BELONGS_TO, 'Image', 'avatar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Логин',
			'password_hash' => 'Password Hash',
      'new_password' => 'Пароль',
      'new_password_confirm' => 'Подтверждение пароля',
			'first_name' => 'Имя',
			'last_name' => 'Фамилия',
			'role' => 'Роль',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'avatar_id' => 'Avatar',
			'auth_token' => 'Auth Token',
			'aut_token_expires' => 'Aut Token Expires',
      'timezone' => 'Временная зона',
		);
	}
  
  public function behaviors() {
    return array(
      'modelErrorBehavior' => array(
        'class' => 'application.behaviors.ModelErrorBehavior',
      ),
      'CSafeContentBehavor' => array(
        'class' => 'application.behaviors.CSafeContentBehavior',
        'attributes' => array('login', 'first_name', 'last_name', 'role'),
      ),
    );
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

		$criteria->compare('id',$this->id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password_hash',$this->password_hash,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);
		$criteria->compare('avatar_id',$this->avatar_id);
		$criteria->compare('auth_token',$this->auth_token,true);
		$criteria->compare('aut_token_expires',$this->aut_token_expires);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
  
  public function encodePassword($password) {
    return md5($password);
  }
  
  public function validatePassword($password) {
    $hash = $this->encodePassword($password);
    if ($hash === $this->password_hash) {
      return true;
    }
    return false;
  }
  
  public function getAvatar($size, $toSize = 0) {
    $avatar = $this->avatar;
    if ($avatar) {
      return Image::url($avatar->id, array('size' => $size, 'toSize' => $toSize));
    } else {  
      return Image::url('empty', array('size' => $size, 'toSize' => $toSize));
    }
  }
}