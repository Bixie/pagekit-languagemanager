<template>

    <div class="uk-form-row uk-form-horizontal">
        <label for="field_title" class="uk-form-label">{{ 'Title' | trans }}</label>

        <div class="uk-form-controls">
            <input id="field_title" class="uk-form-width-large uk-form-large" type="text" name="title"
                   v-model="translation.title">
        </div>
    </div>

</template>
<script>

    export default {

        name: 'TranslationCoreNode',

        props: {
            translation: Object,
            languages: Object,
            types: Object,
        },
    }

</script>