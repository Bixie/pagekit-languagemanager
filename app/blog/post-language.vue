<template>

    <div class="uk-grid">

        <div class="uk-width-medium-1-4">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="connect: '#tab-widget-languages'">
                    <li v-for="locale in language_tabs">
                        <a><img :src="getFlagSource(locale.language)" width="40px" class="uk-margin-small-right" alt=""/>{{ locale.language }}</a>
                    </li>
                </ul>

            </div>

        </div>
        <div class="uk-width-medium-3-4">

            <ul id="tab-widget-languages" class="uk-switcher uk-margin uk-form-stacked">
                <li v-for="locale in language_tabs">
                    <translation-post :translation="translations[locale.language]"
                                         :languages="languages"
                                         :types="types"></translation-post>
                </li>
            </ul>

        </div>

    </div>

</template>

<script>
    import TranslationMixin from '../mixins/translation-mixin';
    import FlagSource from '../mixins/flag-source';
    import TranslationPost from './translation-pagekit.post.vue';

    const vm = {

        section: {
            label: 'Translation',
            priority: 110
        },

        props: ['post', 'data', 'form',],

        mixins: [TranslationMixin, FlagSource,],

        components: {
            'translation-post': TranslationPost,
        },

        data: () => _.merge({
            translations: {},
            languages: {},
            types: {},
            default_language: '',
            model: '',
            model_id: 0,
            type: 'pagekit.post',
        }, window.$languageManager),

        created() {
            this.model = this.types[this.type].model;
            this.model_id = this.post.id;
            this.default_translation_data = {
                excerpt: '',
                meta: {
                    'og:title': '',
                    'og:description': '',
                },
            };
            this.setup();
            //set id for new items
            if (!this.post.id) {
                this.$watch('post.id', id => this.setNewId(id));
            }
        },

        watch: {
            'post.data.markdown': function (value) {
                _.forIn(this.translations, (trans, lang) => {
                    this.translations[lang].data.content_markdown = value;
                });
            },
        },

        methods: {
            hasContentToSave(translation) {
                return (translation.title !== '' ||
                    translation.content !== '' ||
                    translation.data.meta.title !== '' ||
                    translation.data.meta.description !== '' ||
                    translation.data.excerpt !== '');
            },
        },

    };

    if (window.Post) {
        window.Post.components['post-language'] = vm;
    }
    if (window.Translation) {
        window.Translation.components['translation-pagekit.post'] = TranslationPost;
    }
    export default vm;

</script>
