/*global _, Vue*/
import TranslationCoreDefault from '../../components/translation-core.default.vue';
import TranslationCoreWidget from '../../components/translation-core.widget.vue';
import TranslationCoreNode from '../../components/translation-core.node.vue';

import FlagSource from '../../mixins/flag-source';

// @vue/component
window.Translation = {

    el: '#translation-edit',

    name: 'TranslationEdit',

    components: {
        'translation-core.default': TranslationCoreDefault,
        'translation-core.widget': TranslationCoreWidget,
        'translation-core.node': TranslationCoreNode,
    },

    mixins: [FlagSource,],

    data() {
        return _.merge({
            translation: {
                data: {
                    content_markdown: true,
                },
            },
            types: {},
            languages: {},
            form: {},
        }, window.$data);
    },

    computed: {
        editComponent() {
            return this.$options.components[`translation-${this.translation.type}`]  ?
                `translation-${this.translation.type}` : 'translation-core.default';
        },
    },

    created() {
        this.Translations = this.$resource('api/languagemanager/translation{/id}');
    },

    methods: {

        save() {
            this.Translations.save({id: this.translation.id,}, {translation: this.translation,}).then(res => {
                if (!this.translation.id) {
                    window.history.replaceState({}, '', this.$url.route('admin/languagemanager/translation/edit', {
                        id: res.data.translation.id,
                    }));
                }
                this.translation = res.data.translation;
                this.$notify(this.$trans('Translation %title% saved.', {title: this.translation.title,}));

            }, res => this.$notify((res.data.message || res.data), 'danger'));
        },
    },

};

Vue.ready(window.Translation);
