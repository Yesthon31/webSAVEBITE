const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')  // Mengompilasi file JavaScript
   .sass('resources/sass/app.scss', 'public/css');  // Mengompilasi file SASS (CSS)
