const path = require('path');
const webpack = require('webpack')
const autoprefixer = require('autoprefixer')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const ProgressBarPlugin = require('progress-bar-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const chalk = require('chalk');
const WriteFilePlugin = require('write-file-webpack-plugin');

const METADATA = require('./package.json');

const THEME_NAME = 'newtheme'
exports.THEME_NAME = THEME_NAME

let pathsToClean = [
  './wordpress/wp-content/themes/' + THEME_NAME
];

let cleanOptions = {
  root: __dirname,
  verbose: true,
  dry: false,
  watch: false
};
const config = {
  devtool: 'eval-source-map',
  entry: {
    // server: 'webpack-dev-server/client?http://localhost:3000',
    app: './' + THEME_NAME + '/js/app.js',
    vendor: ['jquery', 'lodash', 'draggabilly', 'cookie', 'storageapi']
  },
  output: {
    path: path.join(__dirname, './wordpress/wp-content/themes/' + THEME_NAME),
    publicPath: '//new.localhost/wordpress/wp-content/themes/' + THEME_NAME,
    filename: 'js/[name].js',
  },
  // devServer: {
  //   contentBase: './wordpress/wp-content/themes/' + THEME_NAME,
  //   historyApiFallback: false,
  //   noInfo: true,
  //   compress: true,
  //   quiet: true
  // },
  module: {
    rules: [{
      test: /\.jsx?$/,
      exclude: /(node_modules|bower_components)/,
      use: [{
        loader: 'babel-loader',
        options: { presets: ['es2015'] },
      }],
    }, {
      test: /\.js$/,
      loader: 'eslint-loader'
    }, {
      test: /\.(css|scss|sass)$/,
      loader: ExtractTextPlugin.extract({
        fallback: 'style-loader',
        use: [{
          loader: 'css-loader',
          options: {
            // modules: 1,
            importLoaders: 3,
            sourceMap: true
          }
        }, {
          loader: 'postcss-loader',
          options: {
             sourceMap: true,
            plugins: function() {
              return [
                require('autoprefixer')
              ];
            }
          }
        }, {
          loader: 'resolve-url-loader'
        }, {
          loader: 'sass-loader',
          options: {
            sourceMap: true
          },
        }],
        publicPath: '../'
      })
    }, {
      test: /\.(png|jpe?g|gif)$/,
      loader: 'file-loader',
      options: {
        name: 'images/[name].[ext]',
      }
    }, {
      test: /\.(woff2?|ttf|eot|otf|svg)$/,
      loader: 'file-loader',
      options: {
        name: 'fonts/[name]/[name].[ext]',

      }
    }, {
      test: /\.(mp4|webm)$/,
      loader: 'file-loader',
      options: {
        name: 'videos/[name].[ext]',
      }
    }, {
      test: /\.(png)$/,
      loader: 'file-loader',
      exclude: path.resolve(__dirname, 'newtheme/images'),
      options: {
        name: 'mockups/[name].[ext]',

      }
    }, {
      test: /\.modernizrrc$/,
      loader: 'modernizr-loader!json-loader'
    }, {
      test: /\.json$/,
      loader: 'json-loader'
    }]
  },
  resolve: {
    alias: {
      'jquery': 'jquery',
      'draggabilly': 'draggabilly',
      'cookie': 'jquery.cookie',
      'lodash': 'lodash',
      modernizr$: path.resolve(__dirname, '.modernizrrc'),
      modules: path.join(__dirname, 'node_modules'),
      'storageapi': path.resolve(path.join(__dirname, 'node_modules/jquery-storage-api/jquery.storageapi'))
    },
  },
  plugins: [
    new webpack.ProvidePlugin({ // not acceptable for require suntax
      Modernizr: 'modernizr', // Modernizr is automatically set to the exports of module "modernizr"
      jQuery: 'jquery',
      $: 'jquery',
      jquery: 'jquery',
      _: 'lodash',
      axios: 'axios'
    }),
    new ProgressBarPlugin({
      format: '  build [:bar] ' + chalk.red.bold(':percent') + ' (:elapsed seconds)',
      clear: false
    }),

    new CleanWebpackPlugin(pathsToClean, cleanOptions),

    new webpack.optimize.CommonsChunkPlugin({ name: 'vendor', filename: 'js/vendor.js' }),

    new ExtractTextPlugin({ filename: 'css/[name].css' }),

    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify(METADATA.ENV),
        'VERSION': JSON.stringify(METADATA.version)
      }
    }),
    new CopyWebpackPlugin([
      { context: __dirname + '/' + THEME_NAME + '/newtheme-files', from: './**/*', to: '../' + THEME_NAME }
    ]),
    new CopyWebpackPlugin([
      { context: __dirname + '/' + THEME_NAME + '/mockups', from: './**/*', to: '../' + THEME_NAME + '/mockups' }
    ]),
    new CopyWebpackPlugin([
      { context: __dirname + '/' + THEME_NAME + '/images', from: './**/*', to: '../' + THEME_NAME + '/images' }
    ]),

    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      proxy: 'https://spherealarm.test',
      files: [
        '**/*.php'
      ],
      ghostMode: false,
      injectChanges: true,
      logFileChanges: true,
      logLevel: 'silent',
      logPrefix: 'New',
      notify: false,
      reloadDelay: 0
    }),
    // new webpack.optimize.OccurrenceOrderPlugin(),
    // new webpack.HotModuleReplacementPlugin(),
    // new webpack.NoEmitOnErrorsPlugin(),
    // new WriteFilePlugin({
    //   // exclude hot-update files
    //   test: /^(?!.*(hot)).*/
    // })
  ],
};
//If true JS and CSS files will be minified
if (process.env.NODE_ENV === 'production') {
  devtool: 'eval-source-map',
  config.plugins.push(
    new UglifyJSPlugin({
      minimize: true,
      sourceMap: false,
      output: { comments: false }
    }),
    new OptimizeCssAssetsPlugin()
  );
}
module.exports = config;
