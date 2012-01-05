<?php
return array(
    /**
     * postsテーブルスキーマ定義
     *
     */
    'posts' => array(
        'name' => 'posts',  //DB上の実際のテーブル名
        'primary' => 'id',
        'rowClass' => 'Model_Post',
    ),
    //テーブルが他にあれば同じように追加していく
);
