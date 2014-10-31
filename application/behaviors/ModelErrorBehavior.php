<?
class ModelErrorBehavior extends CBehavior
{
  public function getFirstError() {
    $owner = $this->getOwner();
    $errors = $owner->getErrors();
    $firstError;
    foreach ($errors as $attributeErrors) {
      foreach ($attributeErrors as $error) {
        $firstError = $error;
        break(2);
      }
    }
    return $firstError;;
  }
}