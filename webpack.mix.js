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

mix.webpackConfig({
  resolve: {
    alias: {
      // '@': path.resolve(__dirname, 'resources/assets/js')
    }
  },
  output: {
    publicPath: '/',
    // prod
    // chunkFilename: 'js/[name].[chunkhash].js'
    // dev
    chunkFilename: 'js/[name].js'
  },
  plugins: [
    // ...
    // dev
    // new BundleAnalyzerPlugin(),
  ]
})
  .js('resources/backend/js/app.js', 'public/js/backend')
  .sass('resources/backend/sass/app.scss', 'public/css/backend')
  .version()
  .disableNotifications()