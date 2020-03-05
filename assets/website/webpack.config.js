const path = require('path');
const ManifestPlugin = require('webpack-manifest-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const ip = require('ip');
const DEV_MODE = 'development';
const PROD_MODE = 'production';
const PORT = 8080;
const HOST = 'http://' + ip.address();

module.exports = (env, args) => {
    let mode = args.development ? DEV_MODE : PROD_MODE;

    let config = {
        mode,
        plugins: [
            new ManifestPlugin({
                writeToFileEmit: true
            })
        ],
        entry: {
            'app': './src/index.js'
        },
        output: {
            path: path.resolve(__dirname, '../../public/build/website'),
            filename: '[name]-[hash].js',
            publicPath: mode === 'development' ? 'http://localhost:' + PORT + '/build/website/' : '/build/website/'
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    loader: ['babel-loader']
                },
                {
                    test: /\.scss$/,
                    use: mode === DEV_MODE ? [
                        'style-loader',
                        'css-loader',
                        'sass-loader'
                    ] : ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: [
                            'css-loader', 'sass-loader'
                        ]
                    }),
                },
                {
                    test: /\.(png|jpg|gif)$/,
                    loaders: [
                        {
                            loader: 'url-loader',
                            options: {
                                limit: 0
                            }
                        }
                    ]
                }
            ],
        },
        devServer: {
            contentBase: path.join(__dirname, '../../public/build/website'),
            hot: true,
            hotOnly: true,
            compress: true,
            port: PORT,
            headers: {
                'Access-Control-Allow-Origin': '*'
            }
        }
    };

    if (mode === DEV_MODE) {
        config.plugins.push(
          new StyleLintPlugin({
              files: 'src/scss/**/*.scss'
          })
        );
        config.plugins.push(
          new BrowserSyncPlugin({
              host: 'localhost',
              port: '3000',
              proxy: 'localhost'
          }, { reload: false })
        );
    } else {
        config.plugins.push(
          new ExtractTextPlugin({
              filename: '[name]-[hash].css'
          }),
          new CleanWebpackPlugin()
        );
    }

    return config;
};
