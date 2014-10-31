<div class="l-cols  middle_block">
  <div class="middle_block report_list_all" style="width: 500px;">
      <? $this->widget('Pager', array(
      'pages' => $pagination,
    )) ?>
<div>
<?php
  if (sizeof($reports) > 0):
  foreach ($reports as $report):
?>
  <?php
    $this->renderPartial('//report/reportBlock', array('report' => $report));
  ?>
<?php
  endforeach;
  else:
?>
<div id="no_report">Репортов пока нет...</div>
</div>
<?php
  endif;
?>
      <? $this->widget('Pager', array(
      'pages' => $pagination,
    )) ?>
  </div>
</div>