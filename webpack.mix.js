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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/index.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
    .sass('resources/sass/knowledge.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
    .sass('resources/sass/qa.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
    .sass('resources/sass/info.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
    .sass('resources/sass/huati.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
    .sass('resources/sass/huati-info.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
    .sass('resources/sass/author.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
    .sass('resources/sass/help.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
    .sass('resources/sass/utils.scss', 'public/css')
      .options({
        postCss: [
          require('postcss-css-variables')()
        ]
      })
