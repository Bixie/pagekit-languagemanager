
const FLAG_PATH = '/packages/bixie/languagemanager/assets/flags';

export default {

    computed: {
        language_tabs() {
            return _.filter(this.languages, locale => locale.language !== this.default_language)
        },
    },

    methods: {
        setup() {
            this.Translation = this.$resource('api/languagemanager/translation{/id}');
            //set defaults
            const translations = {};
            _.forIn(this.languages, locale => {
                if (locale.language !== this.default_language) {
                    translations[locale.language] = {
                        id: 0,
                        model_id: this.model_id,
                        model: this.model,
                        language: locale.language,
                        title: '',
                        content: '',
                        data: {
                        },
                    };
                }
            });
            this.translations = translations;
            this.load();
            this.$on('save', this.save);
        },
        load() {
            this.Translation.query({filter: {model: this.model, model_id: this.model_id,}})
                .then(res => {
                    res.data.translations.forEach(translation => {
                        if (translation.model === this.model) {
                            this.translations[translation.language] = translation;
                        }
                    });
                }, res => this.$notify((res.data.message || res.data), 'danger'));
        },
        save() {
            let translations = Object.values(this.translations);
            if (this.node_translations) {
                translations = translations.concat(Object.values(this.node_translations));
            }
            this.Translation.save({id: 'bulk'}, {translations,})
                .then(() => {
                    this.$notify('Translations saved');
                }, res => this.$notify((res.data.message || res.data), 'danger'));
        },
        flag_source(locale) {
            return locale.flag ? this.$url(FLAG_PATH + '/' + locale.flag) : '';
        },
    },

};