<?php
/**
 * ヘルパー関数
 * 本当はグローバル関数を作ることはZendの規約違反なんだけど
 * タイプ数を減らすためによく作ってしまう
 */

/**
 * $this->escape()の省略記法
 *
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * $this->url()の省略記法
 * url('default/index/index?id=5')のように、
 * 文字列で渡してurlを生成できます
 *
 * @param string $urlString {module}/{controller}/{action}?query=value 形式のURL風文字列。パースしてURLに組み立て直します。
 *
 * @return string ルーティング規約に従ったURL
 */
function url($urlString) {
    static $router;
    if (empty($router)) {
        $router = Zend_Controller_Front::getInstance()->getRouter();
    }

    $u = parse_url($urlString);
    if (isset($u['query'])) {
        parse_str($u['query'], $params);
    } else {
        $params = array();
    }

    $urlparams = explode('/', $u['path']);
    if (count($urlparams) < 3) {
        throw new Zend_Exception('cannot build URL string: "' . $urlString . '"');
    }

    list($module, $controller, $action) = $urlparams;
    $urlOptions = array(
        'module' => $module,
        'controller' => $controller,
        'action' => $action
    ) + $params;

    return $router->assemble($urlOptions, null, true);
}

/**
 * Zend_Db_Tableを生成する関数。
 * ActiveRecordなのでARとします。
 *
 * @param string $name テーブル名
 *
 * @return Zend_Db_Table
 */
function AR($name) {
    static $schema, $cache = array();
    if (isset($cache[$name])) {
        return $cache[$name];
    }
    if (!isset($schema)) {
        $config = require APPLICATION_PATH . '/configs/schema.php';
        $schema = new Zend_Db_Table_Definition($config);
    }

    return $cache[$name] = new Zend_Db_Table($name, $schema);
}
