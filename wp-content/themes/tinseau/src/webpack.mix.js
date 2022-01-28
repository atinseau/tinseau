let mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        fallback: {
            "stream": require.resolve("stream-browserify")
        }
    }
})

mix.js('app.js', 'dist').setPublicPath('dist');