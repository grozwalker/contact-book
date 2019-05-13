module.exports = {
  outputDir: 'resource/dist',
  lintOnSave: true,
  configureWebpack: {
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.js',
      }
    },
    entry: {
      app: './resource/src/main.js'
    }
  },
  devServer: {
    public: '0.0.0.0:8089'
  }
};
