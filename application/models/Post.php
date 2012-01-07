<?php

class Model_Post extends Zend_Db_Table_Row_Abstract
{
    //モデル固有のメソッドを追加
    function sayHello() {
        echo 'Hello ' . __CLASS__;
    }
}
