<?php

// PHP2Shell: CVE-2026-109618 and CVE-2026-109619.
$minimums = ['8.3' => '8.3.36', '8.4' => '8.4.27', '8.5' => '8.5.12'];
$branch = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;
if (!isset($minimums[$branch]) || version_compare(PHP_VERSION, $minimums[$branch], '<')) {
    fwrite(STDERR, 'PHP '.PHP_VERSION." is not an approved patched runtime. Use PHP 8.3.36+, 8.4.27+ or 8.5.12+.\n");
    exit(1);
}
echo 'Patched PHP runtime: '.PHP_VERSION."\n";
