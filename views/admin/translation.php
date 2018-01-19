
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
        <div class="uk-grid pk-grid-large pk-width-sidebar-large" data-uk-grid-margin>
            <div class="pk-width-content">

            <div class="uk-form-row uk-form-horizontal">
                <label for="field_title" class="uk-form-label">{{ 'Title' | trans }}</label>

                <div class="uk-form-controls">
                    <input id="field_title" class="uk-width-1-1 uk-form-large" type="text" name="title"
                           v-model="translation.title" v-validate:required>
                </div>
                        <p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">
                        {{ 'Please enter a value' | trans }}</p>
                </div>
            <div class="uk-form-row uk-form-stacked">
                <label for="field_content" class="uk-form-label">{{ 'Content' | trans }}</label>

                <div class="uk-form-controls">
                    <v-editor id="field_content" :value.sync="translation.content"
                              :options="{markdown : translation.data.content_markdown}"></v-editor>
                    <p>
                        <label><input type="checkbox" v-model="translation.data.content_markdown"> {{ 'Enable Markdown' | trans }}</label>
                    </p>
                </div>
            </div>

            </div>
            <div class="pk-width-sidebar">

            <div class="uk-form-row uk-form-stacked">
                <label for="field_model" class="uk-form-label">{{ 'Model' | trans }}</label>

                <div class="uk-form-controls">
                    <input id="field_model" class="uk-width-1-1 uk-form-blank" type="text" name="model"
                           v-model="translation.model" readonly="readonly" v-validate:required>
                </div>
                        <p class="uk-form-help-block uk-text-danger" v-show="form.model.invalid">
                        {{ 'Please enter a value' | trans }}</p>
            </div>
            <div class="uk-form-row uk-form-stacked">
                <label for="field_model" class="uk-form-label">{{ 'ID' | trans }}</label>

                <div class="uk-form-controls">
                    <input id="field_model" class="uk-width-1-1 uk-form-blank" type="text" name="model"
                           v-model="translation.model_id" readonly="readonly" v-validate:required>
                </div>
                        <p class="uk-form-help-block uk-text-danger" v-show="form.model.invalid">
                        {{ 'Please enter a value' | trans }}</p>
            </div>
            <div class="uk-form-row uk-form-stacked">
                <label for="field_language" class="uk-form-label">{{ 'Language' | trans }}</label>

                <div class="uk-form-controls">
                    <input id="field_language" class="uk-width-1-1 uk-form-blank" type="text" name="language"
                           v-model="translation.language" readonly="readonly" v-validate:required>
                </div>
                        <p class="uk-form-help-block uk-text-danger" v-show="form.language.invalid">
                        {{ 'Please enter a value' | trans }}</p>
                </div>
            </div>

        </div>
	</form>

</div>

