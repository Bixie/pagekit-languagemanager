
<?php
$view->script('languagemanager-settings', 'bixie/languagemanager:app/bundle/languagemanager-settings.js', ['bixie-pkframework', 'uikit-nestable'],
    ['version' => $app->module('bixie/pk-framework')->getVersionKey($app->package('bixie/languagemanager')->get('version'))]);
?>
<div id="languagemanager-settings" class="uk-form">
    <div class="uk-grid pk-grid-large" data-uk-grid-margin>
        <div class="pk-width-sidebar">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="{ connect: '#tab-content' }">
                    <li><a><i class="pk-icon-large-pin uk-margin-right"></i> {{ 'Languages' | trans }}</a></li>
                    <li><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'Settings' | trans }}</a></li>
                </ul>

            </div>

        </div>
        <div class="pk-width-content">

            <ul id="tab-content" class="uk-switcher uk-margin">
                <li>

                    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                        <div data-uk-margin>

                            <h2 class="uk-margin-remove">{{ 'Languages' | trans }}</h2>

                        </div>
                        <div data-uk-margin>

                            <button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

                        </div>
                    </div>

                    <div class="uk-form-row uk-form-stacked">
                        <label class="uk-form-label">{{ 'Default language' | trans }}</label>
                        <div class="uk-form-controls">
                            <div class="uk-grid uk-grid-small uk-flex uk-flex-middle" data-uk-grid-margin>
                                <div class="uk-width-1-2">
                                    <em>{{ site_locale_id }}</em>
                                    <span>{{ default_locale_label }}</span>
                                </div>
                                <div class="uk-width-1-2">
                                    <flag-select class="uk-width-1-1" :value.sync="config.default_locale.flag" :flags="flags"></flag-select>
                                </div>
                            </div>
                            <p class="uk-form-help-block">{{ 'Set the default language in Pagekit System settings.' | trans }}</p>
                        </div>
                    </div>

                    <div class="uk-form-row uk-form-stacked">
                        <label class="uk-form-label">{{ 'Active languages' | trans }}</label>
                        <div class="uk-form-controls">
                            <locales-settings v-ref:locale_settings
                                              :value.sync="config.locales"
                                              :languages="languages"
                                              :flags="flags"
                                              :site_locale_id="site_locale_id"></locales-settings>
                        </div>
                    </div>

                </li>
                <li>

                    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                        <div data-uk-margin>

                            <h2 class="uk-margin-remove">{{ 'Settings' | trans }}</h2>

                        </div>
                        <div data-uk-margin>

                            <button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>

                        </div>
                    </div>

                    <bixie-fields :config="$options.fields.settings" :values.sync="config"></bixie-fields>

                </li>
            </ul>

        </div>

    </div>
</div>