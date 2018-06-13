/*global Vue */
import fields from '../../settings/fields';

import LocalesSettings from '../../components/locales-settings.vue';
import FlagSelect from '../../components/flag-select.vue';

// @vue/component
const vm = {

    el: '#languagemanager-settings',

    name: 'LanguagemanagerSettings',

    components: {
        'locales-settings': LocalesSettings,
        'flag-select': FlagSelect,
    },

    fields,

    data: () => _.merge({
        languages: {},
        admin_language: {
            user: {},
            locale_id: '',
        },
        flags: [],
        site_locale_id: '',
        config: {
            default_locale: {
                flag: '',
            },
            locales: [],
        },
        form: {},
    }, window.$data),

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
            this.$http.post('admin/languagemanager/config', {config: this.config, admin_language: this.admin_language,})
                .then(() => {
                    this.$notify('Settings saved.');
                }, res => this.$notify((res.data.message || res.data), 'danger'));
        },
    },

};

Vue.ready(vm);
