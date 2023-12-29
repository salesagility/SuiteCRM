<?php

require_once __DIR__ . '/vendor/autoload.php';

use Pdp\PublicSuffixListManager;
use Pdp\Parser;

// Obtain an instance of the parser
$pslManager = new PublicSuffixListManager();
$parser = new Parser($pslManager->getList());

// Parse a URL
$url = $parser->parseUrl('http://user:pass@www.pref.okinawa.jp:8080/path/to/page.html?query=string#fragment');

// Accessing elements of the URL
var_dump($url);
var_dump($url->__toString());
var_dump($url->getPath());
var_dump($url->getFragment());

// Getting the Host object from the URL
$host = $url->getHost();

// Accessing elements of the Host
var_dump($host);
var_dump($host->__toString());
var_dump($host->getSubdomain());
var_dump($host->getRegistrableDomain());
var_dump($host->getPublicSuffix());

// It's possible to parse a host only, if you prefer
$host = $parser->parseHost('a.b.c.cy');

// Accessing elements of the Host
var_dump($host);
var_dump($host->__toString());
var_dump($host->getSubdomain());
var_dump($host->getRegistrableDomain());
var_dump($host->getPublicSuffix());

// If you just need to know subdomain/registrable domain/public suffix info
// about a host, there are public methods available for that in the Parser
var_dump($parser->getSubdomain('www.scottwills.co.uk'));
var_dump($parser->getRegistrableDomain('www.scottwills.co.uk'));
var_dump($parser->getPublicSuffix('www.scottwills.co.uk'));
