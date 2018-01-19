<template>
    <div class="uk-grid uk-grid-small uk-grid-width-medium-1-2" data-uk-grid-margin>
        <div>
            <select v-model="value" class="uk-width-1-1">
                <option value="">{{ 'Flag' | trans }}</option>
                <option v-for="flag in flags" :value="flag">{{ flag.replace('.png', '') }}</option>
            </select>
        </div>
        <div class="uk-flex uk-flex-middle uk-flex-center">
            <img :src="flag_source" width="50px" alt=""/>
        </div>
    </div>
</template>

<script>

    const FLAG_PATH = '/packages/bixie/languagemanager/assets/flags';

    export default {

        name: 'flag-select',

        props: {
            'value': {type: String, default: ''},
            'flags': Array,
        },

        computed: {
            flag_source() {
                return this.value ? this.$url(FLAG_PATH + '/' + this.value) : '';
            },
        },

    }
</script>
