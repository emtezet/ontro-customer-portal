var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "layout")
     *
     */
    .createSharedEntry('layout', './assets/js/layout.js')

    /*
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('passenger', './assets/js/passenger.js')
    .addEntry('trip', './assets/js/trip.js')

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .enableBuildNotifications()
    .autoProvidejQuery()
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/static', to: 'static' }
    ]))
    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableVersioning(Encore.isProduction())



;

module.exports = Encore.getWebpackConfig();
