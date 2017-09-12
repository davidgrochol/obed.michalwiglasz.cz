<?php

$root = "https://obed.michalwiglasz.cz/fit";
$cache_default_interval = 60 * 60; // 1 hour
$cache_menza_interval = 60;  // 1 minute
$cache_html_interval = $cache_default_interval - 10;

if (isset($_GET['force'])) {
	$cache_default_interval = 0;
	$cache_html_interval = 0;
	$cache_menza_interval = 0;
}


$menza_close = strtotime('2017-06-30 23:59:59');
$menza_open = strtotime('2017-09-18 00:00:01');


$sources = [
	new Source(new Zomato(16506890, 'Camel', 'http://www.restaurace-camel.com/', 'camel')),
	new Source(new Zomato(16505998, 'U 3 opic', 'http://www.u3opic.cz/', 'monkey')),
	new Source(new Velorex), //Zomato(16506807, 'Velorex', 'http://www.restauracevelorex.cz/', 'velorex')),
	new Source(new Zomato(16506806, 'Pad Thai', 'http://padthairestaurace.cz/', 'japanese')),
	new Source(new Zomato(16505880, 'Yvy Restaurant', 'http://www.yvy.cz/', 'yvy')),
	new Source(new Nepal),
	new Source(new Molino),
	new Source(new Zomato(18318157, 'Music Café Semilasso', 'http://restaurace-semilasso.cz/', 'semilasso')),
	new Source(new Kralovska),
];


$menza_filters = [
	'(&nbsp;)' => ' ',
	'(<td class="levy">[HP]\\s+)' => '<td class="levy">',
	'((<td class="levyjid[^"]+"[^>]+>)P\s)ui' => '$1Polévka ',
	'(<small style=\'font-size: 8pt;\'>[^>]+</small>)' => '',
	'(<td class="levy"><small> </span></td>)' => '',
];
