<?php
/**
 * view ヘルパー関数
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
