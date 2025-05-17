/**
 * @type {import('semantic-release').GlobalConfig}
 */
export default {
    branches: [
        {
            name: 'master',
            channel: 'latest',
        },
        {
            name: 'develop',
            channel: 'next',
        },
    ],
    plugins: [
        '@semantic-release/commit-analyzer',
        '@semantic-release/release-notes-generator',
        [
            '@semantic-release/exec',
            {
                prepareCmd: "git-cliff --tag v${nextRelease.version} --output CHANGELOG.md || echo 'Error al generar changelog'",
            },
        ],
        [
            '@semantic-release/exec',
            {
                prepareCmd: 'echo \'{"version": "${nextRelease.version}"}\' > version.json',
            },
        ],
        [
            '@semantic-release/exec',
            {
                prepareCmd: "sed -i \"s/'version' => '.*'/'version' => '${nextRelease.version}'/g\" config/app.php || true",
            },
        ],
        [
            '@semantic-release/git',
            {
                assets: ['CHANGELOG.md', 'version.json', 'config/app.php'],
                message: 'chore(release): ${nextRelease.version}\n\n${nextRelease.notes}',
            },
        ],
    ],
}
