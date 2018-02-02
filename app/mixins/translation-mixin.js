/*global _ */

export default {

    data: () => ({
        default_translation_data: {},
    }),

    computed: {
        language_tabs() {
            return _.filter(this.languages, locale => locale.language !== this.default_language);
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
                        type: this.type,
                        model_id: this.model_id,
                        model: this.model,
                        language: locale.language,
                        title: '',
                        content: '',
                        data: _.merge({
                            content_markdown: false,
                        }, JSON.parse(JSON.stringify(this.default_translation_data))), //prevent references
                    };
                }
            });
            this.translations = translations;
            this.load();
            this.$on('save', this.save);
        },
        setNewId(id) {
            this.model_id = id;
            _.forIn(this.translations, (trans, lang) => {
                this.translations[lang].model_id = id;
            });
            this.save();
        },
        load() {
            if (!this.model_id) {
                return;
            }
            this.Translation.query({filter: {model: this.model, model_id: this.model_id,},})
                .then(res => {
                    res.data.translations.forEach(translation => {
                        this.translations[translation.language] = translation;
                    });
                }, res => this.$notify((res.data.message || res.data), 'danger'));
        },
        save() {
            if (!this.model_id) {
                return;
            }
            let translations = Object.values(this.translations);
            if (this.node_translations) {
                translations = translations.concat(Object.values(this.node_translations));
            }
            translations = translations.filter(this.hasContentToSave);
            if (translations.length === 0) {
                return;
            }
            this.Translation.save({id: 'bulk',}, {translations,})
                .then((res) => {
                    res.data.translations.forEach(translation => {
                        if (translation.model === this.model) {
                            this.translations[translation.language] = translation;
                        }
                    });
                    this.$emit('translations.saved', res.data.translations);
                    this.$notify('Translations saved');
                }, res => this.$notify((res.data.message || res.data), 'danger'));
        },
        hasContentToSave(translation) {
            return (translation.title !== '' || translation.content !== '');
        },
    },

};