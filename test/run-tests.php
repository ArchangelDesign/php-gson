<?php
/**
 * PHPGson Library
 * Simple entity mapper for PHP applications
 * with minimum requirements and dependencies
 *
 * @author Rafal Martinez-Marjanski
 * @package PHPGson
 * @license MIT
 */

define('ROOT', dirname(__DIR__));
$baseDir = __DIR__ . '/cases/';
$cases = scandir($baseDir);
$passedTestCount = 0;
$failedTestCount = 0;

function runTests($case)
{
    global $passedTestCount;
    global $failedTestCount;
    global $baseDir;
    $files = scandir($baseDir . $case);
    foreach ($files as $file) {
        if ($file == '.' || $file == '..')
            continue;
        $className = str_replace('.php', '', $file);
        include_once $baseDir . $case . '/' . $file;
        if (!class_exists($className)) {
            echo "test {$className} in {$file} is invalid.";
            continue;
        }
        try {
            $test = new $className();
            if (!$test instanceof TestInterface) {
                continue;
            }
            runTestClass($test);
            echo "[OK]\n";
            $passedTestCount++;
        } catch (Exception $e) {
            echo '[FAILED] ' . $e->getMessage() . "\n";
            $failedTestCount++;
        }
    }

}

function runTestClass(TestInterface $testClass)
{
    echo 'running ' . $testClass->getTitle() . '... ';
    if (!$testClass->isEnabled()) {
        echo '[DISABLED] ';
        return;
    }
    $testClass->runTest();
}

foreach ($cases as $case) {
    if ($case == '.' || $case == '..')
        continue;

    runTests($case);
}

echo "\n\n";
echo "$passedTestCount tests passed and $failedTestCount failed.\n\n";
