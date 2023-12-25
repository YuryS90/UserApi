const path = require('path');

module.exports = {
    entry: './public/js/main.js', // Путь к вашему основному JavaScript файлу
    output: {
        filename: 'bundle.js', // Название выходного файла
        path: path.resolve(__dirname, 'public/dist'), // Путь для сохранения сгенерированных файлов
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
        ],
    },
};