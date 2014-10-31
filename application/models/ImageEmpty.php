<?php
class ImageEmpty extends CModel
{

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Image the static model class
   */
  public static function model($className = __CLASS__)
  {
    return parent::model($className);
  }
  
  public function attributeNames() {
    return array(
    );
  }

  public function getFileName()
  {
    return Yii::getPathOfAlias('webroot') . '/' . 'img/no_avatar.jpg';
  }
  

}
