module.exports = {

    lintOnSave: false, // 禁用语法Eslint检测
    devServer: { // 设置服务器代理
        proxy: {
            '/audioplayer': {
                target: 'http://localhost:8080',
                changeOrigin: true,
            }
        }
    }

}


