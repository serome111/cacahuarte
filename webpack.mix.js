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

mix.postCss('resources/css/app.css', 'public/css')
    .js('resources/js/dashboard.js', 'public/js')
    .postCss('resources/vendor/bootstrap/css/bootstrap.min.css', 'public/css')
    .postCss('resources/vendor/icofont/icofont.min.css', 'public/css')
    .postCss('resources/vendor/boxicons/css/boxicons.min.css', 'public/css')
    .postCss('resources/vendor/venobox/venobox.css', 'public/css')
    .postCss('resources/vendor/owl.carousel/assets/owl.carousel.min.css', 'public/css')
    .postCss('resources/vendor/aos/aos.css', 'public/css')
    .postCss('resources/css/style.css','public/css')
    .postCss('resources/css/dashboard.css', 'public/css')
    .postCss('resources/css/login.css', 'public/css')
    .postCss('resources/css/css/bootstrap.min.css', 'public/css/css/bootstrap2.min.css');

mix.scripts([
    'resources/vendor/jquery/jquery.min.js',
    'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
    'resources/vendor/jquery.easing/jquery.easing.min.js',
    'resources/vendor/php-email-form/validate.js',
    'resources/vendor/jquery-sticky/jquery.sticky.js',
    'resources/vendor/venobox/venobox.min.js',
    'resources/vendor/owl.carousel/owl.carousel.min.js',
    'resources/vendor/isotope-layout/isotope.pkgd.min.js',
    'resources/vendor/aos/aos.js',
    'resources/js/main.js'
], 'public/js/js.js');

mix.scripts([
    'resources/vendor/bootstrap/js/bootstrap.bundle.min.js'

], 'public/js/bootstrap.bundle.min.js');


if(mix.inProduction())
{
	mix.version();
}

