<?php
$this->widget('RequireJS');
?>

<div class="l-cols  middle_block" style="width: 1055px">
  <div class="middle_block" style="width: auto">
    <h1><?php echo $page->name; ?></h1>
    <style>
      .middle_block img {
        cursor: auto !important;
      }
    </style>
    <div style="margin-top: 30px; padding: 20px;">
      <?php
      echo $page->text;
      ?>
    </div>
  </div>
</div>