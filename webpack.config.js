module.exports = [

    {
        entry: {
            /*views*/
            "languagemanager-translation": "./app/views/admin/translation.js",
            "languagemanager-translations": "./app/views/admin/translations.js",
            "languagemanager-settings": "./app/views/admin/settings.js",
            /*widgets*/
            "widget-language-select": "./app/components/widget-language-select.vue",
            /*translation tabs*/
            "widget-language": "./app/components/widget-language.vue",
            "node-language": "./app/components/node-language.vue",
            "post-language": "./app/blog/post-language.vue",
        },
        output: {
            filename: "./app/bundle/[name].js"
        },
        externals: {
            "lodash": "_",
            "jquery": "jQuery",
            "uikit": "UIkit",
            "vue": "Vue"
        },
        module: {
            loaders: [
                {test: /\.vue$/, loader: "vue"},
                {test: /\.html$/, loader: "vue-html"},
                {test: /\.js/, loader: 'babel', query: {presets: ['es2015']}}
            ]
        }

    }

];
