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

                    <div class="uk-form-row">

                        <input class="uk-width-1-1 uk-form-large" type="text" :placeholder="'Enter Title' | trans"
                               v-model="translations[locale.language].title">
                    </div>

                    <div v-if="widget.type === 'system/text'" class="uk-form-row">
                        <v-editor :value.sync="translations[locale.language].content" :options="{markdown : translations[locale.language].data.content_markdown}"></v-editor>
                    </div>

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
            this.setup();
        },

        watch: {
            'widget.data.markdown': function (value) {
                _.forIn(this.translations, (trans, lang) => {
                    this.translations[lang].data.content_markdown = value;
                });
            },
        },

    };

    window.Widgets.components['widget-language'] = vm;
    export default vm;

</script>
