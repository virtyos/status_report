<?php

/**
 * This is the model class for table "image".
 *
 * The followings are the available columns in table 'image':
 * @property integer $id
 * @property integer $size
 * @property string $mimetype
 * @property integer $revision
 * @property string $created_at
 * @property string $updated_at
 */
class Image extends CActiveRecord
{

  public $uploadedImage;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Image the static model class
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
		return 'image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
      array('uploadedImage', 'file',
        'allowEmpty' => true,
        'types' => 'jpg, jpeg, gif, png',
        'maxSize' => 1024 * 1024 * 5, // 5MB
        'tooLarge' => 'Файл более 5Мб',
      ),
			array('size, revision', 'numerical', 'integerOnly'=>true),
			array('mimetype', 'length', 'max'=>20),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, size, mimetype, revision, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
  
  public function behaviors() {
    return array(
      'modelErrorBehavior' => array(
        'class' => 'application.behaviors.ModelErrorBehavior',
      ),
    );
  }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'size' => 'Size',
			'mimetype' => 'Mimetype',
			'revision' => 'Revision',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('size',$this->size);
		$criteria->compare('mimetype',$this->mimetype,true);
		$criteria->compare('revision',$this->revision);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
  
  public function getFileName($is_create = false)
  {
    $levelsDir = Utils::getLevelsDirABC(Yii::getPathOfAlias('application') . '/../' . 'userfiles/images_lvl', $this->id, $is_create);
    return $levelsDir . '/' . $this->id;
  }
  
  protected function beforeSave() {
    if (parent::beforeSave()) {
      if ($this->isNewRecord) {
        $this->created_at = time();
      } else {
        $this->updated_at = time();
      }
      return true;
    } else {
      return false;
    }
  }

  protected function beforeDelete() {
    if (parent::beforeDelete()) {
      @unlink($this->getFileName());
      return true;
    } else {
      return false;
    }
  }


  //tmp - используется для аякс загрузки. чтобы можно было вычислить объекты, которые не используются
  public static function upload($id, $file, $tmp = false)
  {
    /* @var $file CUploadedFile|String */

    if (!$file) return null;

    $model = null !== $id ? Image::model()->findByPk($id) : null;

    if (null == $model) {
      $model = new Image();
    }

    if ($file instanceof CUploadedFile) {
      $model->mimetype = $file->getType();
      $model->size = $file->getSize();
    } else {
      $model->mimetype = CFileHelper::getMimeType($file);
      $model->size = filesize($file);
    }

    $model->revision++;
    $model->save();


    if ($file instanceof CUploadedFile) {
      $file->saveAs($model->getFileName());
    } else {
      @rename($file, $model->getFileName());
    }
    return $model->id;
  }
  
  public static function url($id, $params = null) {
    $url = Yii::app()->getRequest()->getBaseUrl() . '/image/get/id/' . $id;

    $rev = null;
    if ($params) {
      if (is_array($params)) {
        if (isset($params['rev'])) {
          $rev = $params['rev'];
          unset($params['rev']);
        }
        foreach ($params as $name => $val) {
          $url .= '/' . $name . '/' . $val;
        }
      } else {
        $url .= $params;
      }
    }

    if (!$rev && $id !== 'empty') {
      $img = Image::model()->findByPk($id);
      if ($img) {
        $rev = $img->revision;
      }
    }
    
    if ($rev) {
      $url .= '/?rev=' . $rev;
    }
    return $url;
  }
}