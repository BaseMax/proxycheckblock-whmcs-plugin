<?php
/*
 * @Name: proxycheckblock-whmcs-plugin
 * @Author: Max Base
 * @Repository: https://github.com/BaseMax/proxycheckblock-whmcs-plugin/
 * @Date: 2020-11-13
 */

if(!defined('WHMCS')) {
	die('This file cannot be accessed directly');
}

function proxycheckblock_config() {
    $configarray = array(
		'name' => 'WHMCS ProxyCheckBlock Integration',
		'version' => '1.0',
		'author' => 'MaxBase',
		'description' => 'Integrate ProxyCheckBlock into WHMCS',
		'language' => 'english'
	);
    return $configarray;
}

?>
