
module.exports = {

    name: 'translation-edit',

    el: '#translation-edit',

    data() {
        return _.merge({
            translation: {
                data: {
                    content_markdown: true,
                }
            },
            form: {},
        }, window.$data);
    },

    created() {
        this.Translations = this.$resource('api/languagemanager/translation{/id}');
    },

    computed: {
    },

    methods: {

        save() {
            this.Translations.save({id: this.translation.id}, {translation: this.translation}).then(res => {
                if (!this.translation.id) {
                  window.history.replaceState({}, '', this.$url.route('admin/languagemanager/translation/edit', {id: res.data.translation.id}));
                }
                this.translation = res.data.translation;
                this.$notify(this.$trans('Translation %title% saved.', {title: this.translation.title}));

            }, res => this.$notify((res.data.message || res.data), 'danger'));
        }

    }

};

Vue.ready(module.exports);
