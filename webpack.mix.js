const mix = require('laravel-mix');
var SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')


//this is what generates the service-worker.js file on your public folder
mix.webpackConfig({
    plugins: [
    new SWPrecacheWebpackPlugin({
        cacheId: 'pwa',
        filename: 'service-worker.js',
        staticFileGlobs: ['public/**/*.{css,png,img,js,html}'],
        minify: true,
        stripPrefix: 'public/',
        maximumFileSizeToCacheInBytes: 3497152,
        handleFetch: true,
        dynamicUrlToDependencies: { //you should add the path to your blade files here so they can be cached
        							//and have full support for offline first (example below)
            '/': ['resources/views/home.blade.php'],
           // '/': ['resources/views/layouts/master.blade.php'],
            // '/posts': ['resources/views/posts.blade.php']
        },
        staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /service-worker\.js$/],
        navigateFallback: '/',
        runtimeCaching: [
            {
                urlPattern: new RegExp('https://fonts.'),
                //urlPattern: /^https:\/\/fonts\.googleapis\.com\/css\?family\=Material\+Icons/,
                handler: 'cacheFirst',
                options: {
                    cacheName: 'fonts'
                  }
             },
             //{
                //urlPattern: /^https:\/\/(\d+)\.media\.tumblr\.com\//,
              //  handler: 'cacheFirst'
            // },
        ],
        // importScripts: ['./js/push_message.js']
    })
    ]
});
