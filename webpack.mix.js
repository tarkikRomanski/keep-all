let mix = require('laravel-mix');

mix.options({
    purifyCss: false
});

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.(graphql|gql)$/,
                exclude: /node_modules/,
                loader: 'graphql-tag/loader',
            },
        ],
    },
    resolve: {
        alias: {
            '@styles': path.resolve('resources/assets/sass')
        }
    }
});

mix.sourceMaps()
    .js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.browserSync('http://keep-all.dev.com/');
