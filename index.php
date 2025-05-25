<?php
class IndexController extends Yaf_Controller_Abstract {
   /* acción predeterminada */
   public function indexAction() {
       $this->_view->word = "hola mundo";
       //or
       // $this->getView()->word = "hola mundo";
   }
}
?>