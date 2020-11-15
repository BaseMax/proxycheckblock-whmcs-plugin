<?php
// Max Base
// https://github.com/BaseMax/proxycheck-whmcs-plugin

if (!defined('WHMCS')) {
	die('This file cannot be accessed directly');
}

function siavashblock_config() {
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
