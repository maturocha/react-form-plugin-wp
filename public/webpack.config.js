const path = require('path');

module.exports = (env, argv) => {
  let production = argv.mode === 'production'

  return {
    entry: {
      'frouzebox-plugin-subscription-form': path.resolve(__dirname, 'app/subscription-form.js'),
    },

    output: {
      filename: 'js/[name].js',
      path: path.resolve(__dirname)
    },

    devtool: production ? '' : 'source-map',
  
    resolve: {
      extensions: [".js", ".jsx", ".json"],
    },
  
    module: {
      rules: [
        {
          test: /\.jsx?$/,
          exclude: /node_modules/,
          use: {
              loader: 'babel-loader',
              options: {
                  presets: ['@babel/preset-react'],
                  plugins: [
                    "@babel/plugin-proposal-class-properties"
                  ]
              }
          }
      }, // to transform JSX into JS
      ],
    },
  };
}
