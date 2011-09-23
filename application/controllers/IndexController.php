<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $table = new Model_DbTable_Posts;
        $this->view->row = $table->fetchRow();
    }
}
