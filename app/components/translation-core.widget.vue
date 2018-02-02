<template>

    <div>

        <div class="uk-form-row uk-form-horizontal">
            <label for="field_title" class="uk-form-label">{{ 'Title' | trans }}</label>

            <div class="uk-form-controls">
                <input id="field_title" class="uk-width-1-1 uk-form-large" type="text"
                       name="title" v-model="translation.title">
            </div>
        </div>
        <div v-if="translation.data.show_content" class="uk-form-row uk-form-stacked">
            <label for="field_content" class="uk-form-label">{{ 'Content' | trans }}</label>

            <div class="uk-form-controls">
                <v-editor id="field_content" :value.sync="translation.content"
                          :options="{markdown : translation.data.content_markdown}"></v-editor>
            </div>
        </div>

    </div>

</template>
<script>
/*global _ */

export default {

    name: 'TranslationCoreWidget',

    props: {
        translation: Object,
        languages: Object,
        types: Object,
    },

    created() {
        //init datafields reactive
        if (this.translation.data.show_content === undefined) {
            this.translation.data = _.merge({show_content: false,}, this.translation.data);
        }
    },
}

</script>