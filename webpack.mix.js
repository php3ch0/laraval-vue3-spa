const mix = require('laravel-mix');

mix.webpackConfig({
    watchOptions: {
       ignored: /node_modules/
    },
    resolve: {
       extensions: ['.js', '.vue'],
       alias: {
          '@': __dirname + '/resources',
       }
    }
});

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/css/styles.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ]);

if (mix.inProduction()) {
   mix.version();
}
