const mix = require('laravel-mix');

mix.webpackConfig({
    externals: {
        'lodash-es': '_',
    }
})

mix
    .setPublicPath('dist')
    .js('resources/js/field.js', 'js')
    .sass('resources/sass/field.scss', 'css')
