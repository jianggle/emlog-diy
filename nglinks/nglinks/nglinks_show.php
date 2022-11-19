<?php
!defined('EMLOG_ROOT') && exit('access deined!');

require_once 'nglinks_model.php';

$linksort = json_encode(getLinkSort(true));
$links = json_encode(getJgLinksForJson());

require_once('show.php');
