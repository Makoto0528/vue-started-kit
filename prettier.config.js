/**
 * @see https://prettier.io/docs/en/configuration.html
 * @type {import("prettier").Config}
 */
export default {
    trailingComma: 'es5',
    tabWidth: 4,
    semi: false,
    singleQuote: true,
    printWidth: 140,
    attributeGroups: [
        '^((v-bind)?:?|v-)is$',
        '^v-for$',
        '^v-(if|else-if|else|show|cloak)$',
        '^v-(once|pre|memo)$',
        '^(v-bind)?:?id$',
        '^(v-bind)?:?key$',
        '^(v-bind)?:?ref$',
        '^(v-)?slot$',
        '^#',
        '^v-model$',
        '^v-(?!bind(:|$)|on(:|$)|html$|text$)',
        '^class$',
        '^(v-bind)?:class$',
        '^((v-bind)?:)?(?!data-|v-|:|@|#)',
        '$DEFAULT',
        '^((v-bind)?:)?data-',
        '^v-bind$',
        '^v-on:',
        '^@',
        '^v-html$',
        '^v-text$',
    ],
    plugins: ['prettier-plugin-organize-attributes', 'prettier-plugin-organize-imports', 'prettier-plugin-tailwindcss'],
    overrides: [
        {
            files: ['*.yml'],
            options: {
                useTabs: true,
                tabWidth: 2,
            },
        },
    ],
}
