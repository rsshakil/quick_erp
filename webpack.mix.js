const mix = require('laravel-mix');
require('dotenv').config();
const app_url = process.env.APP_URL;
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
mix.config.webpackConfig.output = {
    chunkFilename: 'js/build_component/[name].js?id=[chunkhash]',
    // publicPath: '/public/', //For server
    publicPath: app_url + 'public/',
};
mix.setPublicPath('public/');
mix.setResourceRoot('../public');
mix.js('resources/js/components/backend/App/app.js', 'public/js/backend_app.js')
    .js('resources/js/components/frontend/App/app.js', 'public/js/frontend_app.js')
    // .scripts(['resources/js/components/frontend/App/app.js'], 'public/js/frontend_app.js')
    .sass('resources/sass/app.scss', 'public/css/backend_app.css')
    .version();

// mix.js('resources/js/components/frontend/App/app.js', 'public/js/frontend_app.js')
//     .version();


// ============
// mix.js('resources/js/components/backend/App/app.js', 'public/js/backend/app')
//     // .scripts(['resources/js/components/frontend/App/app.js'], 'public/js/frontend/app')
//     .sass('resources/sass/app.scss', 'public/css/backend/app')
//     .version();