
<?php
$view->script('translations-index', 'bixie/languagemanager:app/bundle/languagemanager-translations.js', ['bixie-pkframework'],
    ['version' => $app->module('bixie/pk-framework')->getVersionKey($app->package('bixie/languagemanager')->get('version'))]);
?>
<div id="languagemanager-translations" class="uk-form uk-form-horizontal" v-cloak>

	<div class="uk-margin" data-uk-margin>
		<div class="uk-flex uk-flex-middle uk-flex-wrap">

			<h2 class="uk-margin-remove">{{ 'Translations' | trans }}</h2>

			<div class="uk-margin-left" v-show="selected.length">
				<ul class="uk-subnav pk-subnav-icon">
					<li><a class="pk-icon-delete pk-icon-hover" :title="'Delete' | trans"
						   data-uk-tooltip="{delay: 500}" @click.prevent="removeTranslations"
                           v-if="true" v-confirm="'Delete translation?' | trans"></a>
					</li>
				</ul>
			</div>
            <div class="pk-search">
                <div class="uk-search">
                    <input class="uk-search-field" type="text" v-model="config.filter.search" debounce="300">
                </div>
            </div>

        </div>
	</div>

	<div class="uk-overflow-container uk-form">
		<table class="uk-table uk-table-hover uk-table-middle">
			<thead>
			<tr>
				<th class="pk-table-width-minimum"><input type="checkbox" v-check-all:selected.literal="input[name=id]" number></th>
                <th class="pk-table-min-width-200" v-order:title="config.filter.order">{{ 'Title' | trans }}</th>
                <th class="pk-table-min-width-100">
                    <input-filter :title="$trans('Language')" :value.sync="config.filter.language" :options="languagesOptions"></input-filter>
                </th>
                <th class="pk-table-min-width-150" v-order:model="config.filter.order">{{ 'Model' | trans }}</th>
                <th class="pk-table-width-100" v-order:model_id="config.filter.order">{{ 'ID' | trans }}</th>
            </tr>
			</thead>
			<tbody>
			<tr class="check-item" v-for="translation in translations" :class="{'uk-active': active(translation)}">
                <td><input type="checkbox" name="id" value="{{ translation.id }}" number></td>
                <td><a :href="$url.route('admin/languagemanager/translation/edit', { id: translation.id })">{{ translation.title}}</a></td>
                <td>{{ translation.language}}</td>
                <td>{{ translation.model}}</td>
                <td>{{ translation.model_id}}</td>
			</tr>
			</tbody>
		</table>
	</div>

	<h3 class="uk-h1 uk-text-muted uk-text-center" v-show="translations && !translations.length">
        {{ 'No translations found.' | trans }}</h3>

    <v-pagination :page.sync="config.page" :pages="pages" v-show="pages > 1"></v-pagination>

</div>
