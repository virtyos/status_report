<?php

class ImageController extends AppController
{
  private $request;

  function init() {
    $this->request = Yii::app()->request;
  }

  public function actionGet($id) {
    if ($id === 'empty') {
      $img = new ImageEmpty;
    } else {
      $img = Image::model()->findByPk($id);
    }

    if ($img) {
      $this->Process($img);
    } else {
      throw new CHttpException('bad image id');
    }
  }


  protected function resizeImage($filename)
  {
    if ($this->request->getParam('size')) {

      switch ($this->request->getParam('size')) {
        case 'fotorama':
          $width = 800;
          $height = 500;
          break;
        case 'promo':
          $width = 485;
          $height = 295;       
          break;
        case 'large_x':
          $width = 260;
          $height = 180;
          break;
        case 'medium':
          $width = 100;
          break;
        case 'medium_sqw':
          $width = 300;
          $height = 300;
          break;
        case 'small':
          $width = 84;
          break;
        case 'small_sqw':
          $width = 84;
          $height = 84;
          break;
        case 'l_small':
          $width = 53;
          $height = 53;
          break;
        case 'x_small':
          $width = 32;
          $height = 32;
          break;
        default:
          $width = (int)$this->request->getParam('size');

      }
    } else {
      $width = 200;
    }
    
    if ($width <= 0) {
      $width = 200;
    }

    $sim = new SimpleImage;
    if (!$sim->load($filename)) {
      throw new CHttpException(404, 'picture source file not found');
    }

    ob_start();
    $toSize = (int)$this->request->getParam('toSize');
    if ($toSize) {
      $sim->resizeToSize($width, $height);
    } else {
      if (!empty($height)) {
        if ($sim->getWidth() > $sim->getHeight())
          $sim->resizeToWidth($width);
        else
          $sim->resizeToHeight($height);
      }
      else
        $sim->scaleToWidth($width);
    }
    $sim->output();
    $content_type = 'image/jpeg';
    $final_image = ob_get_contents();
    ob_end_clean();
    return array('image' => $final_image, 'content_type' => $content_type);
  }


  public function Process($img) {

    $filename = $img->getFileName();
    $size = $this->request->getParam('size');

    if (!empty($size))
      $result = $this->resizeImage($filename);

    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 259200) . ' GMT');
    header('Pragma: ', '');
    header('Cache-Control: max-age=259200, private');

    header('Content-Type: ' . $result['content_type'], true);
    echo $result['image'];
  }

}

