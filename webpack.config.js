var path = require('path');
var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}
const $ = require('jquery');

Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    .enableSingleRuntimeChunk()
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[hash:8].[ext]'
    })
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('home', './assets/js/home.js')
    .addEntry('order_admin', './assets/js/orderAdmin.js')
    .addEntry('box_wine_admin', './assets/js/boxWineAdmin.js')
    .addEntry('contact_admin', './assets/js/contact_admin.js')
    .addEntry('wine_profile_list', './assets/js/pages/wine_profile/list.js')
    .addEntry('tastuce_list', './assets/js/pages/tastuce/list.js')
    .addEntry('list_wine', './assets/js/pages/wine/list.js')
    .addEntry('mpmd', './assets/js/pages/mpmd.js')
    .addEntry('checkout', './assets/js/checkout.js')
    .addEntry('list_box', './assets/js/pages/box/list.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    // .configureBabel(() => {}, {
    //     useBuiltIns: 'usage',
    //     corejs: 3
    // })

    // enables Sass/SCSS support
    .enableSassLoader(function(options) {
        options.includePaths = [path.resolve(__dirname, "node_modules/bootstrap/scss")]
    })

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
