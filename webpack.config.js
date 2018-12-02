var Encore = require('@symfony/webpack-encore');

Encore
    // directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // will output as web/build/app.js
    .addEntry('prism', [
        './src/AppBundle/Resources/public/js/prism.js',
        './node_modules/prismjs/themes/prism.css',
        './node_modules/prismjs/plugins/line-numbers/prism-line-numbers.css',
        './src/AppBundle/Resources/public/sass/prism.scss'
    ])

    .addEntry('particles', [
        './node_modules/particles.js/particles.js',
        './src/AppBundle/Resources/public/sass/particles.scss'
    ])

    // will output as web/build/global.css
    .addStyleEntry('website', './src/AppBundle/Resources/public/sass/foundation.scss')


    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // create hashed filenames (e.g. app.abc123.css)
    //.enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
