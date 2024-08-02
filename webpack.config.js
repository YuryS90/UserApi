const path = require('path');

const isDev = process.env.NODE_ENV === "development"
const isProd = !isDev
console.log('IS DEV:', isDev)

module.exports = {
    mode: "development",

    entry: {
        main: path.resolve(__dirname, 'public/assets/js', 'index.js'),
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
                use: ["style-loader", "css-loader"]
            },
        ]
    },
}