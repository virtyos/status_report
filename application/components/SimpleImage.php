<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/

class SimpleImage
{

  var $image;
  var $image_type;

  function load($filename)
  {
    $image_info = getimagesize($filename);
    $this->image_type = $image_info[2];
    if ($this->image_type == IMAGETYPE_JPEG) {
      $this->image = imagecreatefromjpeg($filename);
    } elseif ($this->image_type == IMAGETYPE_GIF) {
      $this->image = imagecreatefromgif($filename);
    } elseif ($this->image_type == IMAGETYPE_PNG) {
      $this->image = imagecreatefrompng($filename);
    }
    else
      return false;
    return true;
  }

  function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null)
  {
    if ($image_type == IMAGETYPE_JPEG) {
      imagejpeg($this->image, $filename, $compression);
    } elseif ($image_type == IMAGETYPE_GIF) {
      imagegif($this->image, $filename);
    } elseif ($image_type == IMAGETYPE_PNG) {
      imagepng($this->image, $filename);
    }
    if ($permissions != null) {
      chmod($filename, $permissions);
    }
  }

  function output($image_type = IMAGETYPE_JPEG)
  {
    if ($image_type == IMAGETYPE_JPEG) {
      imagejpeg($this->image, null, 100);
    } elseif ($image_type == IMAGETYPE_GIF) {
      imagegif($this->image);
    } elseif ($image_type == IMAGETYPE_PNG) {
      imagepng($this->image);
    }
  }

  function getWidth()
  {
    return imagesx($this->image);
  }

  function getHeight()
  {
    return imagesy($this->image);
  }

  function getScaleWidth($width)
  {
    if ($this->getWidth() > $width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      return array('w' => $width, 'h' => $height);
    } else {
      return array('w' => $this->getWidth(), 'h' => $this->getHeight());
    }
  }
  
   function resizeToSize($width, $height){
    if ($this->getWidth() > $this->getHeight()) {
      $ratio = $width / $this->getWidth();
      $new_height = $this->getheight() * $ratio;
      if ($new_height > $height) {
        $new_height = $height;
      }  
      $new_width = $width;
      $this->resizeToWidth($width);
    } else {
      $ratio = $height / $this->getHeight();
      $new_width = $this->getWidth() * $ratio;
      if ($new_width > $width) {
        $new_width = $width;
      } 
      $new_height = $height;
      $this->resizeToHeight($height);
    }
    $new_image = imagecreatetruecolor($width, $height);
    imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
    imagecopymerge($new_image, $this->image, (($width - $new_width)/2), (($height - $new_height)/2), 0, 0, $this->getWidth(), $this->getHeight(), 100);
    $this->image = $new_image;   
   }

  function resizeToHeight($height)
  {
    $ratio = $height / $this->getHeight();
    $width = $this->getWidth() * $ratio;
    $this->resize($width, $height);
  }

  function resizeToWidth($width)
  {
    $ratio = $width / $this->getWidth();
    $height = $this->getheight() * $ratio;
    $this->resize($width, $height);
  }

  function scaleToWidth($width)
  {
    if ($this->getWidth() > $width)
      $this->resizeToWidth($width);
  }

  function scale($scale)
  {
    $width = $this->getWidth() * $scale / 100;
    $height = $this->getheight() * $scale / 100;
    $this->resize($width, $height);
  }

  function resize($width, $height)
  {
    $new_image = imagecreatetruecolor($width, $height);
    imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
    $this->image = $new_image;
  }
}
