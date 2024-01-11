<?php
/*
Plugin Name: 模版设置插件
*/
defined('EMLOG_ROOT') || exit('access denied!');

if (!class_exists('TplOptions', false)) {
    include __DIR__ . '/tpl_options.php';
}

//插件激活回调函数
function callback_init() {
    $tplOptions = TplOptions::getInstance();
    $table = $tplOptions->getTable('data');
    $add = "DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $sql = "
    CREATE TABLE IF NOT EXISTS `$table` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `template` varchar(64) NOT NULL,
        `name` varchar(64) NOT NULL,
        `depend` varchar(64) NOT NULL DEFAULT '',
        `data` longtext NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `template` (`template`,`name`)
    )" . $add;
    $tplOptions->getDb()->query($sql);
}
