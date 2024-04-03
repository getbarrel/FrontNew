const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const config = {
    devtool: "source-map",
    devServer: {
        //host: 'localhost',
        //inline: true,
        //hot:true,
        port: 1103,
        contentBase: path.resolve(__dirname, '../')
    },
    entry : {
        'assets/js/vendor' : ['babel-polyfill','jquery','jstree','slick-carousel','jquery-form','handlebars/dist/handlebars.js','jquery-datepicker','swiper/dist/js/swiper.js'],
        'assets/js/main' : ['./js/app','./scss/app.scss']
    },
    output : {
        path: path.resolve(__dirname, '../'),
        filename:'[name].js',
    },
    module: {
        rules: [
            {
                test:/\.js$/,
                exclude: /node_modules/,
                use : {
                    loader: 'babel-loader',
                    options: {
                        cacheDirectory:true
                    }
                }
            }
            ,{
                test: /\.(css|scss|sass)$/,

                use: [
                    process.env.NODE_ENV !== 'production' ? 'style-loader' : MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                            importLoaders: 2
                        },
                    },{
                        loader: 'postcss-loader'
                    },{
                        loader: 'sass-loader',
                        options: {
                            outputStyle: 'expanded',
                            sourceMap: true
                        },
                    }
                ]
            },{
                test: /\.(svg|eot|ttf|woff|woff2)$/,
                loader: 'url-loader',
                //include: path.resolve(__dirname, '../'),
                options: {
                    publicPath: './',
                    limit: 10000,
                },
            }
            ,{
                test: /\.(png|jpg|gif|jpeg)$/,
                loader: 'file-loader',
                //include: path.resolve(__dirname, '../'),
                options: {
                    name: '[path][name].[ext]',
                    publicPath: '../../',
                    outputPath: '/',
                },
            }
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        }),
        new MiniCssExtractPlugin({
            filename: "assets/css/main.css",
            chunkFilename: "assets/css/main_id.css"
        })
    ]
};

module.exports = config;