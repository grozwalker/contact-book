module.exports = {
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
  }
};
