const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');

// public page
mix.js([
    'resources/js/public/bootstrap.bundle.min.js',
    'resources/js/public/functions.js'
    ], 'public/assets/js/all.js');

mix.styles([
    'resources/css/public/bootstrap.css',
    'resources/css/public/theme.css',
], 'public/assets/css/all.css');

// app
mix.js([
    'resources/js/public/bootstrap.bundle.min.js',
    'resources/js/app.js'
    ], 'public/assets/js/app.js');

mix.styles([
    'resources/css/app/bootstrap.css',
    'resources/css/app/circle-progress.css',
    'resources/css/app/theme.css',
    'resources/css/app/custom.css',
], 'public/assets/css/app.css');

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.scss'],
        alias: require(`${__dirname}/resources/js/config/aliases`)
    },
    devtool: 'source-map'
});
