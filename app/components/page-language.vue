<template>

    <div class="uk-grid">

        <div class="uk-width-medium-1-5">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="connect: '#tab-post-languages'">
                    <li v-for="locale in language_tabs">
                        <a><img :src="getFlagSource(locale.language)" width="40px" class="uk-margin-small-right" alt=""/>{{ locale.language }}</a>
                    </li>
                </ul>

            </div>

        </div>
        <div class="uk-width-medium-4-5">

            <ul id="tab-post-languages" class="uk-switcher uk-margin uk-form-stacked">
                <li v-for="locale in language_tabs">

                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-3-4">
                            <translation-default :translation="translations[locale.language]"
                                                :languages="languages"
                                                :types="types"></translation-default>

                        </div>
                        <div class="uk-width-medium-1-4">

                            <div class="uk-form-row">
                                <label class="uk-form-label">{{ 'Menu title' | trans }}</label>
                                <input class="uk-width-1-1" type="text"
                                       v-model="node_translations[locale.language].title">
                            </div>

                            <!--<div class="uk-form-row">-->
                                <!--<label class="uk-form-label">{{ 'Slug' | trans }}</label>-->
                                <!--<input class="uk-width-1-1" type="text"-->
                                       <!--v-model="node_translations[locale.language].data.slug">-->
                            <!--</div>-->

                        </div>
                    </div>
                </li>
            </ul>

        </div>

    </div>

</template>

<script>
    import TranslationMixin from '../mixins/translation-mixin';
    import FlagSource from '../mixins/flag-source';

    export default {

        section: {
            label: 'Translation',
            priority: 110
        },

        props: ['node', 'form',],

        mixins: [TranslationMixin, FlagSource,],

        components: {
            'translation-default': require('./translation-core.default.vue'),
        },

        data: () => _.merge({
            translations: {},
            node_translations: {},
            languages: {},
            types: {},
            default_language: '',
            model: '',
            model_id: 0,
            type: 'core.page',
        }, window.$languageManager),

        created() {
            this.model = this.types[this.type].model;
            this.model_id = this.node.data.defaults.id;
            this.setup();
            //add node translations
            this.loadNodeTranslations();
        },

        ready() {
            this.$watch('page.data.markdown', value => {
                _.forIn(this.translations, (trans, lang) => {
                    this.translations[lang].data.content_markdown = value;
                });
            });
        },

        computed: {
            page() {
                let page = {data: {markdown: false,}};
                _.forEach(this.$root.$children, vm => {
                    if (vm.$options.section.label === 'Content') {
                        page = vm.page;
                    }
                });
                return page;
            },
        },

        methods: {
            loadNodeTranslations() {
                const node_translations = {};
                _.forIn(this.languages, locale => {
                    if (locale.language !== this.default_language) {
                        node_translations[locale.language] = {
                            id: 0,
                            type: 'core.node',
                            model_id: this.node.id,
                            model: 'Pagekit\\Model\\Node',
                            language: locale.language,
                            title: '',
                            content: '',
                            data: {
                                slug: '',
                            },
                        };
                    }
                });
                this.node_translations = node_translations;
                this.Translation.query({filter: {model: 'Pagekit\\Model\\Node', model_id: this.node.id,}})
                    .then(res => {
                        res.data.translations.forEach(translation => {
                            if (translation.model === 'Pagekit\\Model\\Node') {
                                this.node_translations[translation.language] = translation;
                            }
                        });
                    }, res => this.$notify((res.data.message || res.data), 'danger'));
            },
        },

    };

</script>
