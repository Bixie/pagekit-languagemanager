<template>
    <li class="uk-nestable-item" :data-locale_id="value.locale_id">
        <div v-if="edit" class="uk-nestable-panel">
            <div class="uk-grid uk-grid-small uk-flex uk-flex-middle" data-uk-grid-margin>
                <div class="uk-width-1-4">
                    <em>{{ value.locale_id }}</em>
                </div>
                <div class="uk-width-1-2">
                    <flag-select class="uk-width-1-1" :value.sync="value.flag" :flags="flags"></flag-select>
                </div>
                <div class="uk-width-1-4 uk-text-right">
                    <a @click="save" class="uk-icon-save" :title="$trans('Save')" data-uk-tooltip="delay:300"></a>
                </div>
            </div>
            <div class="uk-margin uk-form-stacked">
                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Site title' | trans }}</label>

                    <div class="uk-form-controls">
                        <input type="text" v-model="value.site.title"
                               class="uk-form-width-large">
                    </div>
                </div>

                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Site logo' | trans }}</label>
                    <div class="uk-form-controls uk-form-width-large">
                        <input-image :source.sync="value.site.view.logo"></input-image>
                    </div>
                </div>

                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Meta description' | trans }}</label>
                    <div class="uk-form-controls uk-form-width-large">
                        <textarea class="uk-form-width-large" rows="5" v-model="value.site.meta.description"></textarea>
                    </div>
                </div>

                <div class="uk-form-row">
                    <label class="uk-form-label">{{ 'Meta image' | trans }}</label>
                    <div class="uk-form-controls uk-form-width-large">
                        <input-image :source.sync="value.site.meta.image"></input-image>
                    </div>
                </div>

            </div>
        </div>
        <div v-else class="uk-nestable-panel">
            <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                <div class="uk-width-2-3 uk-flex uk-flex-middle uk-flex-space-between">
                    <div>
                        <em>{{ value.locale_id }}</em>
                        <span class="uk-margin-small-left">{{ label }}</span>
                    </div>
                    <img :src="flag_source" width="50px" :alt="value.flag"/>
                </div>
                <div class="uk-width-1-3 uk-text-right">
                    <a @click="edit = true"
                       class="uk-icon-edit uk-icon-justify"
                       :title="$trans('Edit')" data-uk-tooltip="delay:300"></a>
                    <a v-if="true" @click="$parent.remove(index)"
                       class="uk-icon-trash-o uk-icon-justify"
                       v-confirm="$trans('Delete language from settings?')"
                       :title="$trans('Remove')" data-uk-tooltip="delay:300"></a>
                    <a class="uk-icon-arrows-v uk-nestable-handle uk-icon-justify"
                       :title="$trans('Change ordering')" data-uk-tooltip="delay:300"></a>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
import FlagSelect from './flag-select.vue';

import FlagSource from '../mixins/flag-source';

export default {

    name: 'LocaleSet',

    components: {
        'flag-select': FlagSelect,
    },

    mixins: [FlagSource,],

    props: {'value': Object, 'flags': Array,},

    data: () => ({edit: false, }),

    computed: {
        label() {
            return this.$parent.languages[this.value.locale_id] || '';
        },
        flag_source() {
            return this.value.flag ? this.$url(this.flag_path + '/' + this.value.flag) : '';
        },
    },

    created() {
        if (this.value.isNew) {
            this.edit = true;
            delete this.value.isNew;
        }
    },

    methods: {
        save() {
            this.edit = false;
            this.$parent.$emit('save');
        },
    },

}
</script>
