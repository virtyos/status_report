<div class="reportBlock">
  <div class="left">
    <div class="ava">
      <a href="/user/show/<?php echo $report->user->id?>">
        <img src="<?php echo $report->user->getAvatar('small_sqw', 1);?>">
      </a>
    </div>
  </div>
  <div class="text">
    <?php
      echo $report->text;
    ?>
  </div>
  <div class="date"><?php echo Utils::getHumanDate($report->created_at); ?></div>
</div>