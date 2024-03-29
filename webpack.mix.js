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


mix.js('resources/js/home.js', 'public/js').react();
mix.js('resources/js/productDetail.js', 'public/js').react();
mix.js('resources/js/profile.js', 'public/js').react();
mix.js('resources/js/product.js', 'public/js').react();

