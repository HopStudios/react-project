const webpack = require('webpack');
const ESLintPlugin = require('eslint-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const FileManagerPlugin = require('filemanager-webpack-plugin');
const paths = require('./config/paths');

module.exports = (env, argv) => {
  const isEnvDevelopment = argv.mode === 'development'
  return {
    devtool: 'inline-source-map',
    entry: {
      app: [
        paths.appJs,
        paths.appScss
      ]
    },
    watchOptions: {
      ignored: /node_modules/,
    },
    resolve: {
      extensions: ['.js', '.jsx', '.ts', '.tsx'],
    },
    module: {
      rules: [
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          use: ['babel-loader']
        },
        {
          test: /\.(s(a|c)ss)$/,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader',
            {
              loader: 'sass-loader',
              options: {
                sourceMap: true
              }
            }
          ]
        }
      ]
    },
    plugins: [
      new ESLintPlugin({
        // Plugin options
        extensions: ['js', 'mjs', 'jsx', 'ts', 'tsx'],
        formatter: require.resolve('react-dev-utils/eslintFormatter'),
        eslintPath: require.resolve('eslint'),
        failOnError: !isEnvDevelopment,
        context: paths.srcJsPath,
        cache: true,
        cacheLocation: paths.cacheLocation,
        // ESLint class options
        resolvePluginsRelativeTo: __dirname,
        baseConfig: {
          extends: [require.resolve('eslint-config-react-app/base')],
          rules: {
            'react/react-in-jsx-scope': 'error',
          }
        },
      }),
      new MiniCssExtractPlugin({
        // Options similar to the same options in webpackOptions.output
        // both options are optional
        filename: './css/app.css',
      }),
      new FileManagerPlugin({
        events: {
          onEnd: {
            copy: (
              isEnvDevelopment ? [
                {
                  source: paths.buildPath,
                  destination: paths.themesPath
                }
              ] : [
                {
                  source: paths.addonPath,
                  destination: paths.distPath
                },
                {
                  source: paths.buildPath,
                  destination: paths.distThemesPath
                }
              ]
            )
          }
        }
      })
    ],
    output: {
      path: paths.buildPath,
      filename: './js/app.js'
    },
    optimization: {
      // minification - only performed when mode = production
      minimizer: [
        // css minification
        new CssMinimizerPlugin(),
      ]
    },
  };
}