<div class="l-cols  middle_block">
  <div class="middle_block" style="width: 250px;">
  
 <?php $form = $this->beginWidget('CActiveForm', array(
    'action' => '',
    'id' => 'edit-form',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
  )); ?>
    <?php
      if ($statusSave) :
        echo 'Изменения успешно сохранены<br>
        <a href="/user/show/'.$user->id.'">Перейти на страницу профиля</a><br><br><br>';
      endif;
    ?>
    <?php
      if ($user->hasErrors()) :
    ?>
      <div class="error_list">
        <?php
          echo $user->getFirstError();
        ?>
        <?php
          if (isset($imageError)) :
            echo '<br>' . $imageError;
          endif;
        ?>
      </div>
    <?php
      endif;
    ?>
    <input type="hidden" name="id" value="<?php echo $user->id;?>">
    <div class="form-group">
      <?php echo $form->labelEx($user, 'login'); ?>
      <?php echo $form->textField($user, 'login', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
      <?php echo $form->labelEx($user, 'new_password'); ?>
      <?php echo $form->passwordField($user, 'new_password', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
      <?php echo $form->labelEx($user, 'new_password_confirm'); ?>
      <?php echo $form->passwordField($user, 'new_password_confirm', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
      <?php echo $form->labelEx($user, 'first_name'); ?>
      <?php echo $form->textField($user, 'first_name', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
      <?php echo $form->labelEx($user, 'last_name'); ?>
      <?php echo $form->textField($user, 'last_name', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
      <?php echo $form->labelEx($user, 'role'); ?>
      <?php echo $form->dropDownList($user,'role',array('user'=>'user','admin'=>'admin')); ?>
    </div>
    <div class="form-group">
      <label><img src="<?php echo $user->getAvatar('small_sqw', 1);?>"><br> Аватар (jpg, png, gif, не более 5мб)
      </label>
      <input type="file" name="avatar">
    </div>
    <br><br>
    <?php echo CHtml::submitButton('Сохранить', array('class' => 'btn btn-default')); ?>
  <?php $this->endWidget(); ?>
  </div>
</div>