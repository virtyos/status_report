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
</div>