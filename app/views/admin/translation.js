import FlagSource from '../../mixins/flag-source';

window.Translation = {

    name: 'translation-edit',

    el: '#translation-edit',

    mixins: [FlagSource],

    components: {
        'translation-core.default': require('../../components/translation-core.default.vue'),
        'translation-core.widget': require('../../components/translation-core.widget.vue'),
        'translation-core.node': require('../../components/translation-core.node.vue'),
    },

    data() {
        return _.merge({
            translation: {
                data: {
                    content_markdown: true,
                }
            },
            types: {},
            languages: {},
            form: {},
        }, window.$data);
    },

    created() {
        this.Translations = this.$resource('api/languagemanager/translation{/id}');
    },

    computed: {
        editComponent() {
            return this.$options.components[`translation-${this.translation.type}`]  ?
               `translation-${this.translation.type}` : 'translation-core.default';
        },
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
        },
    }

};

Vue.ready(window.Translation);
