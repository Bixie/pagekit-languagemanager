<template>

    <div class="uk-grid">

        <div class="uk-width-medium-1-5">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="connect: '#tab-node-languages'">
                    <li v-for="locale in language_tabs">
                        <a><img :src="getFlagSource(locale.language)" width="40px" class="uk-margin-small-right" alt=""/>{{ locale.language }}</a>
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
/*global _ */
import PageLanguage from './page-language.vue';

import TranslationMixin from '../mixins/translation-mixin';
import FlagSource from '../mixins/flag-source';

const vm = {

    name: 'NodeLanguage',

    section: {
        label: 'Translation',
        priority: 110,
    },

    props: ['node', 'form',],

    mixins: [TranslationMixin, FlagSource,],

    data: () => _.merge({
        translations: {},
        languages: {},
        types: {},
        default_language: '',
        model: '',
        model_id: 0,
        type: 'core.node',
    }, window.$languageManager),

    created() {
        this.model = this.types[this.type].model;
        this.model_id = this.node.id;
        this.setup();
        //set id for new items
        if (!this.node.id) {
            this.$watch('node.id', id => this.setNewId(id));
        }
    },

};

window.Site.components['page:language'] = PageLanguage;
window.Site.components.language = vm;
//needs to be exported to compile template
export default vm;
</script>
