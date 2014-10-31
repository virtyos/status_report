<div class="l-cols  middle_block">
  <div class="middle_block" style="width: 250px;">
  
 <?php $form = $this->beginWidget('CActiveForm', array(
    'action' => '/login',
    'id' => 'login-form',
  )); ?>
    <?php
      if ($model->hasErrors()) :
    ?>
      <div class="error_list">
        <?php
          echo $model->getFirstError();
        ?>
      </div>
    <?php
      endif;
    ?>
    <script type="text/javascript">
      document.write('<input type="hidden" name="timezone" value="'+new Date().getTimezoneOffset()/60+'">');
    </script>
    <div class="form-group">
      <?php echo $form->labelEx($model, 'username'); ?>
      <?php echo $form->textField($model, 'username', array('class' => 'form-control')); ?>
    </div>
    <div class="form-group">
      <?php echo $form->labelEx($model, 'password'); ?>
      <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'id' => 'pwd')); ?>
    </div>
    <?php echo CHtml::submitButton('Войти', array('class' => 'btn btn-default')); ?>
  <?php $this->endWidget(); ?>
  </div>
</div>