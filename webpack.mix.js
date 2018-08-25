let mix = require('laravel-mix');

mix.options({
    purifyCss: false
});

mix.sourceMaps()
    .js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.browserSync('http://keep-all.dev.com/');
