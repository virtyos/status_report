<div class="reportBlock">
  <div class="left">
    <div class="ava">
      <a href="/user/show/<?php echo $user->id?>">
        <img src="<?php echo $user->getAvatar('small_sqw', 1);?>">
      </a>
    </div>
  </div>
  <div class="text">
    <a href="/user/show/<?php echo $user->id?>">
      <?php
        echo $user->login;
        $name = $user->first_name . ' ' . $user->last_name;
        $trimName = trim($name);
        if (!empty($trimName)):
      ?>
      (<?php echo $name;?>)
      <?php
        endif;
      ?>
    </a>
  </div>
  <div class="date" style="width: 150px;">
    <?php
      if (Yii::app()->user->role === 'admin'):
    ?>
      <input type="hidden" name="userId" value="<?php echo $user->id;?>">
      <div id="actions">
        <a href="/user/edit?id=<?php echo $user->id;?>"><img src="/img/icon_edit.png"></a>
        <a href="javascript:void()" class="user_del"><img src="/img/icon_delete.png"></a>
      </div>
      <div id="del_cnfirm" style="display: none;">
        Точно удалить?<br>
        <a href="javascript:void()" class="del_yes">Да</a>
        <a href="javascript:void()" class="del_no">Нет</a>
      </div>
    <?php
      endif;
    ?>
  </div>
</div>