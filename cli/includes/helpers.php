<?php

use Illuminate\Container\Container;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Define the ~/.valet path as a constant.
 */
define('VALET_HOME_PATH', $_SERVER['HOME'] . '/.valet');
define('VALET_ROOT_PATH', realpath(__DIR__ . '/../../'));
define('VALET_BIN_PATH', realpath(__DIR__ . '/../../bin/'));
define('VALET_SERVER_PATH', realpath(__DIR__ . '/../../server.php'));
define('VALET_STATIC_PREFIX', '41c270e4-5535-4daa-b23e-c269744c2f45');
define('VALET_HOSTS_PATH', realpath('/mnt/c/Windows/System32/drivers/etc/hosts'));

/**
 * Output the given text to the console.
 *
 * @param string $output
 *
 * @return void
 */
function info($output)
{
    output('<fg=yellow>' . $output . '</>');
}

/**
 * Output the given text to the console.
 *
 * @param string $output
 *
 * @return void
 */
function warning($output)
{
    output('<fg=red>' . $output . '</>');
}

/**
 * Output the given text to the console.
 *
 * @param string $output
 *
 * @return void
 */
function success($output)
{
    output('<fg=green>' . $output . '</>');
}

/**
 * Output a table to the console.
 *
 * @param array $headers
 * @param array $rows
 *
 * @return void
 */
function table(array $headers = [], array $rows = [])
{
    $table = new Table(new ConsoleOutput());

    $table->setHeaders($headers)->setRows($rows);

    $table->render();
}

/**
 * Output the given text to the console.
 *
 * @param string $output
 *
 * @return void
 */
function output($output)
{
    if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'testing') {
        return;
    }

    (new ConsoleOutput())->writeln($output);
}

if (!function_exists('resolve')) {
    /**
     * Resolve the given class from the container.
     *
     * @param string $class
     *
     * @return mixed
     */
    function resolve($class)
    {
        return Container::getInstance()->make($class);
    }
}

/**
 * Swap the given class implementation in the container.
 *
 * @param string $class
 * @param mixed  $instance
 *
 * @return void
 */
function swap($class, $instance)
{
    Container::getInstance()->instance($class, $instance);
}

if (!function_exists('retry')) {
    /**
     * Retry the given function N times.
     *
     * @param int      $retries
     * @param callable $fn
     * @param int      $sleep
     *
     * @throws Exception
     *
     * @return mixed
     */
    function retry($retries, $fn, $sleep = 0)
    {
        beginning:
        try {
            return $fn();
        } catch (Exception $e) {
            if (!$retries) {
                throw $e;
            }

            $retries--;

            if ($sleep > 0) {
                usleep($sleep * 1000);
            }

            goto beginning;
        }
    }
}

/**
 * Verify that the script is currently running as "sudo".
 *
 * @throws Exception
 *
 * @return void
 */
function should_be_sudo()
{
    if (!isset($_SERVER['SUDO_USER'])) {
        throw new Exception('This command must be run with sudo.');
    }
}

if (!function_exists('tap')) {
    /**
     * Tap the given value.
     *
     * @param mixed    $value
     * @param callable $callback
     *
     * @return mixed
     */
    function tap($value, callable $callback)
    {
        $callback($value);

        return $value;
    }
}

if (!function_exists('ends_with')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    function ends_with($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if (substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }
}

/**
 * Get the user.
 */
function user()
{
    if (!isset($_SERVER['SUDO_USER'])) {
        return $_SERVER['USER'];
    }

    return $_SERVER['SUDO_USER'];
}

/**
 * Get the user's group.
 */
function group()
{
    if (!isset($_SERVER['SUDO_USER'])) {
        return exec('id -gn ' . $_SERVER['USER']);
    }

    return exec('id -gn ' . $_SERVER['SUDO_USER']);
}

/**
 * Search and replace using associative array.
 *
 * @param array  $searchAndReplace
 * @param string $subject
 *
 * @return string
 */
function str_array_replace($searchAndReplace, $subject)
{
    return str_replace(array_keys($searchAndReplace), array_values($searchAndReplace), $subject);
}

/**
 * Get user input from cli.
 *
 * @param $question
 * @param $suggestion
 * @param $default
 *
 * @return string
 */
function ask($question, $suggestion = null, $default = null)
{
    return CliPrompt::prompt($question, false, $suggestion, $default);
}

/**
 * Get user hidden input from cli.
 *
 * @param $question
 * @param $suggestion
 * @param $default
 *
 * @return string
 */
function ask_secret($question, $suggestion = null, $default = null)
{
    return CliPrompt::prompt($question, true, $suggestion, $default);
}
