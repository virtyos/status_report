<?php

class UserController extends AppController {

  public function filters() {
    return array(
      array('application.filters.AuthAppFilter')
    );
  }

  public function actionIndex() {
    $this->redirect('/user/show');
  }


  public function actionShow() {
    $userId = Yii::app()->request->getParam('id');
    if (!$userId) {
      $user = $this->currentUser;
    } else {
      $user = User::model()->findByPk($userId);
      if (!$user) {
        throw new CHttpException(404);
      }
    }
    $this->renderData['user'] = $user;
    $this->render('show', $this->renderData);
  }
  
  
  public function actionEdit() {
    $user = User::model()->findByPk(Yii::app()->request->getParam('id'));
    if (!$user) {
      throw new CHttpException(404);
    }
    if ($user->id !== $this->currentUser->id && $this->currentUser->role !== 'admin') {
      throw new CHttpException(403);
    }
    $user->scenario = 'edit';
    $statusSave = Yii::app()->request->getParam('statusSave');
    if ($_POST) {
      $user->setAttributes($_POST['User'], false);
      $user->new_password = $_POST['User']['new_password'];
      $user->new_password_confirm = $_POST['User']['new_password_confirm'];
      if (!empty($user->new_password)) {
        $user->password_hash = $user->encodePassword($user->new_password);
      }
      if ($user->save()) {
        $ava = CUploadedFile::getInstanceByName('avatar');
        if ($ava) {
          $image = new Image;
          $image->uploadedImage = $ava;
          $imageError = '';
          if (!$image->validate()) {
            $imageError = $image->getFirstError();
          } else {
            $imageId = Image::upload(null, $image->uploadedImage);
            if (!$imageId) {
              $imageError = 'Ошибка при аплоуде';
            } else {
              $user->avatar_id = $imageId;
              $user->save();
              $statusSave = true;
            }
          }
        $this->renderData['imageError'] = $imageError;
        } else {
          $statusSave = true;
        }
        if ($statusSave) {
          $this->redirect('/user/edit?id='.$user->id.'&statusSave=1');
        }
      }
    }
    $this->renderData['user'] = $user;
    $this->renderData['statusSave'] = $statusSave;
    $this->render('edit', $this->renderData);
  }
  
  public function actionAdd() {
    $user = User::model()->findByPk(Yii::app()->request->getParam('id'));
    if ($this->currentUser->role !== 'admin') {
      throw new CHttpException(403);
    }
    $user = new User;
    $user->scenario = 'add';
    $statusSave = false;
    if ($_POST) {
      $user->setAttributes($_POST['User'], false);
      $user->new_password = $_POST['User']['new_password'];
      $user->new_password_confirm = $_POST['User']['new_password_confirm'];
      if (!empty($user->new_password)) {
        $user->password_hash = $user->encodePassword($user->new_password);
      }
      if ($user->save()) {
        $ava = CUploadedFile::getInstanceByName('avatar');
        if ($ava) {
          $image = new Image;
          $image->uploadedImage = $ava;
          $imageError = '';
          if (!$image->validate()) {
            $imageError = $image->getFirstError();
          } else {
            $imageId = Image::upload(null, $image->uploadedImage);
            if (!$imageId) {
              $imageError = 'Ошибка при аплоуде';
            } else {
              $user->avatar_id = $imageId;
              $user->save();
              $statusSave = true;
            }
          }
        $this->renderData['imageError'] = $imageError;
        } else {
          $statusSave = true;
        }
        if ($statusSave) {
          $this->redirect('/user/show/id/'.$user->id);
        }
      }
    }
    $this->renderData['user'] = $user;
    $this->renderData['statusSave'] = $statusSave;
    $this->render('add', $this->renderData);
  }
  
  public function actionDelete() {
    $userId = Yii::app()->request->getParam('id');
    $deleteResult = User::model()->deleteByPk($userId);
    $result = array();    
    if ($deleteResult > 0) {
      $result['status'] = self::AJAX_STATUS_SUCCESS;
    } else {
      $result['status'] = self::AJAX_STATUS_ERROR;
    }
    echo json_encode($result); 
  }
  
  public function actionGetReports() {
    $userId = Yii::app()->request->getParam('userId');
    $limit = Yii::app()->request->getParam('limit');
    $offset = Yii::app()->request->getParam('offset');
    $result = array();
    $reports = Report::model()->findAll(
      array(
        'limit' => $limit,
        'offset' => $offset,
        'condition' => 'owner_id = :owner_id',
        'params' => array(':owner_id' => $userId),
        'order' => 'created_at DESC'
      )
    );
    $result['status'] = self::AJAX_STATUS_SUCCESS;
    if (sizeof($reports) > 0 || $offset == 0) {
      $result['html'] = $this->renderPartial('reports', array('reports' => $reports), true);
    } else {
      $result['html'] = null;
    }
    echo json_encode($result);
  }
  
  public function actionAll() {
    $cr = new CDbCriteria;
    $cr->order = 'id ASC';
    

    $users = User::model()->findAll($cr);
    $this->renderData['users'] = $users;
   
    $this->render('all', $this->renderData);    
  }

}