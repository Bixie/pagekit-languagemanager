
<?php
$view->script('translation-edit', 'bixie/languagemanager:app/bundle/languagemanager-translation.js', ['bixie-pkframework', 'editor'],
    ['version' => $app->module('bixie/pk-framework')->getVersionKey($app->package('bixie/languagemanager')->get('version'))]);
?>
<div id="translation-edit" v-cloak>
	<form class="uk-form" v-validator="form" @submit.prevent="save | valid">

		<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
			<div data-uk-margin>

				<h2 v-if="translation.id" class="uk-margin-remove">{{ 'Edit translation' | trans }}</h2>
				<h2 v-else class="uk-margin-remove">{{ 'New translation' | trans }}</h2>

			</div>
			<div>

				<a class="uk-button uk-margin-small-right" :href="$url.route('admin/languagemanager/translations')">{{ translation.id ?
					'Close' :
					'Cancel' | trans }}</a>
				<button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

			</div>
		</div>

        <div class="uk-panel uk-margin uk-panel-box uk-panel-box-primary">

            <div class="uk-grid uk-form-stacked" data-uk-grid-margin>
                <div class="uk-width-medium-1-3">
                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Type' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            {{ types[translation.type].label }}
                        </div>
                    </div>
                </div>
                <div class="uk-width-medium-1-3">
                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Model' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            {{ translation.model }}
                        </div>
                    </div>
                </div>
                <div class="uk-width-medium-1-6">
                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'ID' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <a v-if="translation.model_url"
                               :href="translation.model_url" class="uk-margin-small-left" target="_blank">
                                <i class="uk-icon-external-link uk-margin-small-right"></i>
                                {{ translation.model_id }}
                            </a>
                            <span v-else>{{ translation.model_id }}</span>

                        </div>
                    </div>
                </div>
                <div class="uk-width-medium-1-6">
                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Language' | trans }}</label>
                        <div class="uk-form-controls uk-form-controls-text">
                            <img :src="getFlagSource(translation.language)" width="40px" alt=""/>
                            {{ translation.language }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <component :is="editComponent"
                   :translation="translation"
                   :languages="languages"
                   :types="types"></component>
	</form>

</div>

