var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './assets/js/app.js')
    .addEntry('jquery', './assets/js/jquery.min.js')
    .addEntry('popper', './assets/js/popper.min.js')
    .addEntry('bootstrap', './assets/js/bootstrap.min.js')
    .addEntry('select', './assets/js/select.min.js')

    .addStyleEntry('materia', './assets/css/materia.min.css')
    .addStyleEntry('autocomplete', './assets/css/autocomplete.min.css')

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
