const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  productionSourceMap: false,
  configureWebpack: config => {
    if(process.env.NODE_ENV === "production") {
      config.output.filename = 'js/feed.[name].min.js'
      config.output.chunkFilename = 'js/feed.[name].min.js'
    } else {
      config.output.filename = 'js/[name].js'
      config.output.chunkFilename = 'js/[name].js';
    }
  }
})
