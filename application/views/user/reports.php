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
<?php
  endif;
?>