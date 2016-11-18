<?php
require_once dirname( __FILE__ ) . '/../src/Autoloader.php';

cardgate\api\Autoloader::register();

$oCardGate = new cardgate\api\Client( 1, 'p03k03pl44p', TRUE );
$oCardGate->setIp( $_SERVER['REMOTE_ADDR'] );
$oCardGate->setLanguage( 'nl' );

$iSiteId = 44;
$sSiteKey = 'A45ag3#';
