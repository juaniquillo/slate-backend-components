<?php

declare(strict_types=1);

/*
 * Runs Pest with --parallel everywhere except Windows, where parallel
 * workers race over the shared Testbench skeleton
 * (bootstrap/cache/services.php) and fail with "Access is denied".
 *
 * Inside CI (GitHub Actions sets CI and GITHUB_ACTIONS), Pest runs in
 * --ci mode with plain output suited to action logs. Note: phpunit.xml
 * intentionally enables no testdox printer — Paratest workers crash
 * resolving the terminal width without a TTY, so testdox stays off
 * everywhere and Pest renders its own output instead.
 */

$isWindows = PHP_OS_FAMILY === 'Windows';

$isCi = getenv('GITHUB_ACTIONS') !== false || getenv('CI') !== false;

$args = array_slice($_SERVER['argv'], 1);

if (! $isWindows && ! in_array('--parallel', $args, true)) {
    $args[] = '--parallel';
}

if ($isCi && ! in_array('--ci', $args, true)) {
    $args[] = '--ci';
}

$command = escapeshellarg(PHP_BINARY).' '.escapeshellarg(__DIR__.'/../vendor/bin/pest');

foreach ($args as $arg) {
    $command .= ' '.escapeshellarg($arg);
}

passthru($command, $exitCode);

exit($exitCode);
