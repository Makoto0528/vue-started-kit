<?php

use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Set\LaravelLevelSetList;

return static function (RectorConfig $rectorConfig) : void {
    // Paths to analyze
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap/app.php',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/public',
    ]);

    // Files or rules to skip
    $rectorConfig->skip([
        AddOverrideAttributeToOverriddenMethodsRector::class,
    ]);

    // Main sets for Rector 2.x
    $rectorConfig->sets([
        LaravelLevelSetList::UP_TO_LARAVEL_110,
        LevelSetList::UP_TO_PHP_84,
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
        SetList::PRIVATIZATION,
        SetList::STRICT_BOOLEANS,
        SymfonySetList::SYMFONY_CODE_QUALITY,
    ]);

    // Laravel Bootstrap files
    $rectorConfig->bootstrapFiles([
        __DIR__ . '/vendor/autoload.php',
        __DIR__ . '/bootstrap/app.php',
    ]);

    // Enable automatic imports
    $rectorConfig->importNames();
    $rectorConfig->parallel();

    // Set PHP version
    $rectorConfig->phpVersion(PhpVersion::PHP_84);
};
