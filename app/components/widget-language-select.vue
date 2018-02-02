<template>

    <div class="uk-grid pk-grid-large pk-width-sidebar-large" data-uk-grid-margin>
        <div class="pk-width-content uk-form-horizontal">

            <div class="uk-form-row">
                <label for="form-title" class="uk-form-label">{{ 'Title' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-title" class="uk-form-width-large" type="text"
                           name="title" v-model="widget.title"
                           v-validate:required>
                    <p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">{{ 'Title cannot be blank.' | trans }}</p>
                </div>
            </div>

            <div class="uk-form-row">
                <label for="form-view" class="uk-form-label">{{ 'View' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-view" v-model="widget.data.view" class="uk-form-width-medium">
                        <option value="dropdown">{{ 'Dropdown' | trans }}</option>
                        <option value="flags">{{ 'Flags' | trans }}</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="pk-width-sidebar">

            <partial name="settings"></partial>

        </div>
    </div>

</template>

<script>
/*global _*/

// @vue/component
const vm = {

    name: 'WidgetLanguageSelect',

    section: {
        label: 'Settings',
    },

    replace: false,

    props: {'widget': Object, 'config': Object, 'form': Object,},

    created: function () {
        this.$options.partials = this.$parent.$options.partials;
        this.$set('widget.data', _.merge({
            view: 'dropdown',
        }, this.widget.data));
    },
};

window.Widgets.components['bixie-language-select:settings'] = vm;
//needs to be exported to compile template
export default vm;

</script>
