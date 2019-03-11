const path = require('path');

module.exports = {
	publicPath: '/backend/',
  pluginOptions: {
    'style-resources-loader': {
      preProcessor: 'scss',
      patterns: [path.resolve(__dirname, './src/lib/scss/elements.scss')]
    }
  }
}
