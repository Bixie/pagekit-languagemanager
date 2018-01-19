
<?php
$view->script('languagemanager-settings', 'bixie/languagemanager:app/bundle/languagemanager-settings.js', ['bixie-pkframework', 'uikit-nestable'],
    ['version' => $app->module('bixie/pk-framework')->getVersionKey($app->package('bixie/languagemanager')->get('version'))]);
?>
<div id="languagemanager-settings">
    <div class="uk-grid pk-grid-large" data-uk-grid-margin>
        <div class="pk-width-sidebar">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="{ connect: '#tab-content' }">
                    <li><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'Settings' | trans }}</a></li>
                </ul>

            </div>

        </div>
        <div class="pk-width-content">

            <ul id="tab-content" class="uk-switcher uk-margin">
                <li class="uk-form">

                    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                        <div data-uk-margin>

                            <h2 class="uk-margin-remove">{{ 'Languagemanager Settings' | trans }}</h2>

                        </div>
                        <div data-uk-margin>

                            <button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

                        </div>
                    </div>

                    <div class="uk-form-row uk-form-stacked">
                        <label for="active_languages" class="uk-form-label">{{ 'Active languages' | trans }}</label>
                        <div class="uk-form-controls">
                            <locales-settings v-ref:locale_settings
                                              :value.sync="config.locales"
                                              :languages="languages"
                                              :flags="flags"></locales-settings>
                        </div>
                    </div>

                    <bixie-fields :config="$options.fields.settings" :values.sync="config"></bixie-fields>

                </li>
            </ul>

        </div>

    </div>
</div>