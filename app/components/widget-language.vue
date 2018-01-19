<template>

    <div class="uk-grid">

        <div class="uk-width-medium-1-4">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="connect: '#tab-widget-languages'">
                    <li v-for="locale in language_tabs">
                        <a><img :src="flag_source(locale)" width="40px" class="uk-margin-small-right" alt=""/>{{ locale.language }}</a>
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
                        <v-editor :value.sync="translations[locale.language].content" :options="{markdown : widget.data.markdown}"></v-editor>
                    </div>

                </li>
            </ul>

        </div>

    </div>

</template>

<script>
    import TranslateMixin from '../mixins/translate-mixin';

    const vm = {

        section: {
            label: 'Translation',
            priority: 110
        },

        props: ['widget', 'config', 'form',],

        mixins: [TranslateMixin,],

        data: () => _.merge({
            translations: {},
            languages: {},
            default_language: '',
            model: 'Pagekit\\Model\\Widget',
            model_id: 0,
        }, window.$languageManager),

        created() {
            this.model_id = this.widget.id;
            this.setup();
        },

    };

    window.Widgets.components['widget-language'] = vm;
    export default vm;

</script>
