const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
  ...defaultConfig,
  entry: {
    'index': path.resolve(__dirname, 'src/js/index.js'),
    'rrze-typesettings': path.resolve(__dirname, 'src/js/rrze-typesettings.js')    
  },
  output: {
    path: path.resolve(__dirname, 'build'),
    filename: '[name].min.js'
  }
};
