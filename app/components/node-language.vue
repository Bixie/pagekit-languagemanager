<template>

    <div class="uk-grid">

        <div class="uk-width-medium-1-5">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="connect: '#tab-node-languages'">
                    <li v-for="locale in language_tabs">
                        <a><img :src="flag_source(locale)" width="40px" class="uk-margin-small-right" alt=""/>{{ locale.language }}</a>
                    </li>
                </ul>

            </div>

        </div>
        <div class="uk-width-medium-4-5">

            <ul id="tab-node-languages" class="uk-switcher uk-margin uk-form-stacked">
                <li v-for="locale in language_tabs">

                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Menu title' | trans }}</label>
                        <input class="uk-width-1-1" type="text"
                               v-model="translations[locale.language].title">
                    </div>

                    <!--<div class="uk-form-row">-->
                        <!--<label class="uk-form-label">{{ 'Slug' | trans }}</label>-->
                        <!--<input class="uk-width-1-1" type="text"-->
                               <!--v-model="translations[locale.language].data.slug">-->
                    <!--</div>-->

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

        props: ['node', 'form',],

        mixins: [TranslateMixin,],

        data: () => _.merge({
            translations: {},
            languages: {},
            default_language: '',
            model: 'Pagekit\\Model\\Node',
            model_id: 0,
        }, window.$languageManager),

        created() {
            this.model_id = this.node.id;
            this.setup();
        },

    };

    window.Site.components['page:language'] = require('./page-language.vue');
    window.Site.components['language'] = vm;
    export default vm;

</script>
