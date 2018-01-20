import FlagSource from '../../mixins/flag-source';

module.exports = {

    name: 'translations',

    el: '#languagemanager-translations',

    mixins: [FlagSource],

    data() {
        return _.merge({
            translations: false,
            config: {
                filter: this.$session.get('bixie.languagemanager.translations.admin.filter', {
                    search: '',
                    type: '',
                    language: '',
                    order: 'title asc',
                }),
                page: 0
            },
            pages: 0,
            count: 0,
            types: {},
            languages: {},
            selected: [],
        }, window.$data);
    },

    created() {
        this.Translations = this.$resource('api/languagemanager/translation{/id}');
        this.$watch('config.page', this.load, {immediate: true});
    },

    computed: {
        languagesOptions: function () {

            const options = [];
            _.forEach(this.languages, locale => {
                options.push({value: locale.language, text: locale.language});
            });
            return [{label: this.$trans('Filter by'), options: options}];
        },

        typesOptions: function () {

            const options = [];
            _.forEach(this.types, type => {
                options.push({value: type.name, text: type.label});
            });
            return [{label: this.$trans('Filter by'), options: options}];
        },

    },

    methods: {

        load() {
            return this.Translations.query(this.config).then(res => {
                this.translations = res.data.translations;
                this.pages = res.data.pages;
                this.count = res.data.count;
                this.selected = [];
            });
        },

        active(translation) {
            return this.selected.indexOf(translation.id) !== -1;
        },

        getSelected() {
            return this.translations.filter(translation => this.selected.indexOf(translation.id) !== -1);
        },

        removeTranslations() {
            this.Translations.delete({id: 'bulk'}, {ids: this.selected}).then(() => {
                this.load();
                this.$notify('Translations removed.');
            });
        },

        getTypeLabel(type_name) {
            return this.types[type_name] ? this.types[type_name].label : type_name;
        },

    },

    watch: {

        'config.filter': {
            handler(filter) {
                if (this.config.page) {
                    this.config.page = 0;
                } else {
                    this.load();
                }
                this.$session.set('bixie.languagemanager.translations.admin.filter', filter);
            },
            deep: true
        }

    },


};

Vue.ready(module.exports);

