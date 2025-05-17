<?php

use Illuminate\Support\Facades\Config;

describe('app_version', function () {
    $versionFile = __DIR__ . '/../../version.json';
    $backupFile = __DIR__ . '/../../version.json.bak';

    beforeEach(function () use ($versionFile, $backupFile) {
        if (file_exists($versionFile)) {
            rename($versionFile, $backupFile);
        }
    });

    afterEach(function () use ($versionFile, $backupFile) {
        if (file_exists($versionFile)) {
            unlink($versionFile);
        }
        if (file_exists($backupFile)) {
            rename($backupFile, $versionFile);
        }
    });

    test('returns version from valid version.json file', function () use ($versionFile) {
        file_put_contents($versionFile, json_encode(['version' => '1.2.3']));
        expect(app_version())->toBe('1.2.3');
    });

    test('returns default when version.json does not exist', function () {
        Config::set('app.version', '0.0.0');
        expect(app_version())->toBe('0.0.0');
    });

    test('returns default when version.json is corrupted', function () use ($versionFile) {
        file_put_contents($versionFile, '{not-json}');
        Config::set('app.version', 'x.y.z');
        expect(app_version())->toBe('x.y.z');
    });

    test('returns default when version.json lacks version field', function () use ($versionFile) {
        file_put_contents($versionFile, json_encode(['foo' => 'bar']));
        Config::set('app.version', 'abc');
        expect(app_version())->toBe('abc');
    });
});
