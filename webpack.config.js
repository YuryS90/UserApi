const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const isDev = process.env.NODE_ENV === "development"
const isProd = !isDev
console.log('IS DEV:', isDev)

module.exports = {
    mode: "development",

    devtool: isDev ? 'source-map' : false, // Включение source-map в режиме разработки

    entry: {
        main: path.resolve(__dirname, 'public/assets/js', 'index.js'),
        index: path.resolve(__dirname, 'public/assets/js', 'lte.js'),
    },

    output: {
        filename: "[name].[contenthash].js",
        path: path.resolve(__dirname, 'public/assets/dist'),
        clean: true
    },

    module: {
        rules: [
            {
                test: /\.css$/i,
                use: [MiniCssExtractPlugin.loader, "css-loader"],
            }
        ]
    },

    plugins: [
        new HtmlWebpackPlugin(),

        new MiniCssExtractPlugin({
            filename: "[name].[contenthash].css"
        })
    ],
}