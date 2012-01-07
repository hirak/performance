<?php

class Model_Post extends Zend_Db_Table_Row_Abstract
{
    //modifiedを自動更新するよう、save()をオーバーライド
    function save() {
        $this->modified = date('c');
        return parent::save();
    }

    //モデル固有のメソッドを追加
    function sayHello() {
        echo 'Hello ' . __CLASS__;
    }
}
