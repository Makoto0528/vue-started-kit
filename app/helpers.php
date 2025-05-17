<?php

// @codeCoverageIgnoreStart
if (! function_exists('app_version')) {
    // @codeCoverageIgnoreEnd

    function app_version() : string
    {
        $versionFile = base_path('version.json');

        if (file_exists($versionFile)) {
            $contents = file_get_contents($versionFile);

            if (false !== $contents) {
                $versionData = json_decode($contents, true);
                if (is_array($versionData) && isset($versionData['version']) && is_string($versionData['version'])) {
                    return $versionData['version'];
                }
            }
        }

        return config()->string('app.version', '0.0.0');
    }
}
