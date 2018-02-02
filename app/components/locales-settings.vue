<template>

    <div>

        <div class="uk-grid uk-grid-small" data-uk-grid-margin>
            <div class="uk-width-1-4">
                <select v-model="new_locale.locale_id" class="uk-width-1-1">
                    <option value="">{{ 'Language' | trans }}</option>
                    <option v-for="language in languages" :value="$key">{{ language }}</option>
                </select>
            </div>
            <div class="uk-width-1-2">
                <flag-select class="uk-width-1-1" :value.sync="new_locale.flag" :flags="flags"></flag-select>
            </div>
            <div class="uk-width-1-4">
                <button type="button" @click="add" class="uk-button uk-button-small">{{ 'Add' | trans }}</button>
            </div>
        </div>

        <ul v-el:locales-nestable class="uk-nestable">
            <locale-set v-for="locale in value" :value.sync="locale" :flags="flags"></locale-set>
        </ul>

    </div>

</template>
<script>
/*global _, UIkit */
import FlagSelect from './flag-select.vue';
import LocaleSet from './locale-set.vue';

const default_locale = () => ({
    isNew: true,
    locale_id: '',
    language: '',
    region: '',
    flag: '',
    site: {
        title: '',
        meta: {
            description: '',
            image: '',
        },
        view: {
            logo: '',
        },
    },
});

export default {

    name: 'LocalesSettings',

    components: {
        'flag-select': FlagSelect,
        'locale-set': LocaleSet,
    },

    props: {
        'value': Array,
        'languages': Object,
        'flags': Array,
        'site_locale_id': String,
    },

    data() {
        return {
            new_locale: {},
        }
    },

    created() {
        this.new_locale = _.defaultsDeep({}, default_locale());
    },

    ready() {
        UIkit.nestable(this.$els.localesNestable, {
            maxDepth: 1,
            handleClass: 'uk-nestable-handle',
            group: 'lm.locales',
        }).on('change.uk.nestable', (e, nestable, el, type) => {
            if (type && type !== 'removed') {
                const locales = [];
                _.forEach(nestable.list(), option => {
                    locales.push(_.find(this.value, 'locale_id', `${option.locale_id}`));
                });
                this.value = locales;
                this.$emit('save');
            }
        });
    },

    methods: {
        add() {
            if (!this.new_locale.locale_id) {
                return;
            }
            if (this.new_locale.locale_id === this.site_locale_id) {
                this.$notify('Cannot add the deafult language as extra language');
                return;
            }
            const parts = this.new_locale.locale_id.split('_');
            this.new_locale.language = parts[0].toLowerCase();
            this.new_locale.region = (parts[1] || '').toLowerCase();

            this.value.push(this.new_locale);
            this.new_locale = _.defaultsDeep({}, default_locale());
            this.$emit('save');
        },
        remove(index) {
            this.value.splice(index, 1);
            this.$emit('save');
        },
    },

};


</script>