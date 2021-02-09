const { mix } = require('laravel-mix');

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

mix.combine([
    'resources/assets/css/AdminLTE.css',
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/mystyle.css',
    'resources/assets/css/bootstrap-datepicker3.css',
    'resources/assets/css/skins/_all-skins.css',
    'resources/assets/css/select2.css',
    'resources/assets/css/font-awesome.css'

], 'public/css/all.css');

mix.js([
    'resources/assets/js/app.js',
    'resources/assets/js/bootstrap-datepicker.js',
    'resources/assets/js/select2.full.js',
    'resources/assets/js/notify.js',
    'resources/assets/js/adminlte.js'

], 'public/js');
