
module.exports = {

    name: 'languagemanager-settings',

    el: '#languagemanager-settings',

    fields: require('../../settings/fields'),

    components: {
       'locales-settings': require('../../components/locales-settings.vue')
    },

    data() {
        return _.merge({
            languages: {},
            flags: [],
            config: {},
            form: {},
        }, window.$data);
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
