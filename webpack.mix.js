const mix = require('laravel-mix')
let BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

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

mix.browserSync({
  proxy: 'dashboard.localhost',
  files: [
    'public/dist/js/*.js',
    'public/dist/css/*.css',
  ]
})

mix.webpackConfig({
  resolve: {
    alias: {
      // '@': path.resolve(__dirname, 'resources/assets/js')
    }
  },
  output: {
    publicPath: '/',
    chunkFilename: process.env.NODE_ENV == 'development' ? 'dist/js/[name].js' : 'dist/js/[name].[chunkhash].js',
  },
  plugins: [
    // ...
    // dev
    // new BundleAnalyzerPlugin(),
  ]
})
  .js('resources/backend/js/app.js', 'public/dist/js/backend')
  .sass('resources/backend/sass/app.scss', 'public/dist/css/backend')
  .version()
  .disableNotifications()
