<?php
class Pager extends CLinkPager
{
  public $maxButtonCount = 200;

  public function run()
  {
    $buttons = $this->createPageButtons();
    if (empty($buttons))
      return;

    echo '<div class="pagin">
				' . implode(" ", $buttons) . '
                </div>';
  }

  protected function createPageButton($label, $page, $class, $hidden, $selected)
  {
    if (!is_int($label))
      return;
    if ($hidden || $selected) {
      $button = '<a href="' . $this->createPageUrl($this->getController(), $page) . '" class="active">
				   ' . $label . '
				  </a>';
    } else {
      $button = '<a href="' . $this->createPageUrl($this->getController(), $page) . '">
				   ' . $label . '
				  </a>';
    }
    return $button;
  }

  public function createPageUrl($controller, $page)
  {
    $params = $this->getPages()->params === null ? $_REQUEST : $this->getPages()->params;
    unset($params['PHPSESSID']);
    if ($page > 0) // page 0 is the default
      $params[$this->getPages()->pageVar] = $page + 1;
    else
      unset($params[$this->getPages()->pageVar]);
    return $controller->createUrl($this->getPages()->route, $params);
  }
}