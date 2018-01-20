
module.exports = {

    name: 'languagemanager-settings',

    el: '#languagemanager-settings',

    fields: require('../../settings/fields'),

    components: {
       'locales-settings': require('../../components/locales-settings.vue'),
        'flag-select': require('../../components/flag-select.vue'),
    },

    data() {
        return _.merge({
            languages: {},
            flags: [],
            site_locale_id: '',
            config: {
                default_locale: {
                    flag: '',
                },
                locales: [],
            },
            form: {},
        }, window.$data);
    },

    computed: {
        default_locale_label() {
            return this.languages[this.site_locale_id] || '';
        },
    },

    created() {
        if (!_.isArray(this.config.locales)) {
            this.config.locales = [];
        }
    },

    ready() {
        this.$refs.locale_settings.$on('save', this.save);
    },

    methods: {
        save() {
            this.$http.post('admin/languagemanager/config', {config: this.config}).then(() => {
                this.$notify('Settings saved.');
            }, res => this.$notify((res.data.message || res.data), 'danger'));
        },
    }

};

Vue.ready(module.exports);
