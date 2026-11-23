<?php

// PHP security releases from November 2026.
$minimums = ['8.3' => '8.3.37', '8.4' => '8.4.28', '8.5' => '8.5.13'];
$branch = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;
if (!isset($minimums[$branch]) || version_compare(PHP_VERSION, $minimums[$branch], '<')) {
    fwrite(STDERR, 'PHP '.PHP_VERSION." is not an approved patched runtime. Use PHP 8.3.37+, 8.4.28+ or 8.5.13+.\n");
    exit(1);
}
echo 'Patched PHP runtime: '.PHP_VERSION."\n";
