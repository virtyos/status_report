<div class="l-cols  middle_block">
  <div class="middle_block report_list_all" style="width: 500px;">
<?php
  if (sizeof($users) > 0):
  foreach ($users as $user):
?>
  <?php
    $this->renderPartial('//user/userBlock', array('user' => $user));
  ?>
<?php
  endforeach;
  else:
?>
<div id="no_report">Пользователей пока нет... Очень странно!</div>
<?php
  endif;
?>
  </div>
</div>