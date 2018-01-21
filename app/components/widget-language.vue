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
                    <translation-widget :translation="translations[locale.language]"
                                         :languages="languages"
                                         :types="types"></translation-widget>
                </li>
            </ul>

        </div>

    </div>

</template>

<script>
    import TranslationMixin from '../mixins/translation-mixin';
    import FlagSource from '../mixins/flag-source';

    const vm = {

        section: {
            label: 'Translation',
            priority: 110
        },

        props: ['widget', 'config', 'form',],

        mixins: [TranslationMixin, FlagSource,],

        components: {
            'translation-widget': require('./translation-core.widget.vue'),
        },

        data: () => _.merge({
            translations: {},
            languages: {},
            types: {},
            default_language: '',
            model: '',
            model_id: 0,
            type: 'core.widget',
        }, window.$languageManager),

        created() {
            this.model = this.types[this.type].model;
            this.model_id = this.widget.id;
            this.default_translation_data = {
                show_content: this.widget.type === 'system/text',
            };
            this.setup();
            //set id for new items
            if (!this.widget.id) {
                this.$watch('widget.id', id => this.setNewId(id));
            }
        },

        watch: {
            'widget.data.markdown': function (value) {
                _.forIn(this.translations, (trans, lang) => {
                    this.translations[lang].data.content_markdown = value;
                });
            },
        },

    };

    window.Widgets.components['language'] = vm;
    export default vm;

</script>
