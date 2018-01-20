<template>

    <div class="uk-grid pk-grid-large pk-width-sidebar-large uk-form-stacked" data-uk-grid-margin>
        <div class="pk-width-content">

        <div class="uk-form-row uk-form-horizontal">
            <label for="field_title" class="uk-form-label">{{ 'Title' | trans }}</label>

            <div class="uk-form-controls">
                <input id="field_title" class="uk-width-1-1 uk-form-large" type="text" name="title"
                       v-model="translation.title">
            </div>
        </div>
        <div class="uk-form-row uk-form-stacked">
            <label for="field_content" class="uk-form-label">{{ 'Content' | trans }}</label>

            <div class="uk-form-controls">
                <v-editor id="field_content" :value.sync="translation.content"
                          :options="{markdown : translation.data.content_markdown}"></v-editor>
            </div>
        </div>

        <div class="uk-form-row uk-form-stacked">
            <label for="field_excerpt" class="uk-form-label">{{ 'Excerpt' | trans }}</label>

            <div class="uk-form-controls">
                <v-editor id="field_excerpt" :value.sync="translation.data.excerpt"
                          :options="{markdown : translation.data.content_markdown}"></v-editor>
            </div>
        </div>
        </div>
        <div class="pk-width-sidebar">
            <h3>{{ 'Meta' | trans }}</h3>

            <div class="uk-form-row uk-form-stacked">
                <label for="form-meta-title" class="uk-form-label">{{ 'Title' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-meta-title" class="uk-form-width-large" type="text"
                           v-model="translation.data.meta['og:title']">
                </div>
            </div>

            <div class="uk-form-row uk-form-stacked">
                <label for="form-meta-description" class="uk-form-label">{{ 'Description' | trans }}</label>
                <div class="uk-form-controls">
                    <textarea id="form-meta-description" class="uk-form-width-large" rows="5" type="text"
                              v-model="translation.data.meta['og:description']"></textarea>
                </div>
            </div>

        </div>

    </div>

</template>
<script>

    export default {

        name: 'TranslationPagekitBlog',

        props: {
            translation: Object,
            languages: Object,
            types: Object,
        },

    }

</script>