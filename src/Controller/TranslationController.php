<?php

namespace Bixie\Languagemanager\Controller;

use Pagekit\Application as App;
use Bixie\Languagemanager\Model\Translation;

/**
 * Translation Admin View Controller
 *
 * @Access (admin=true)
 */
class TranslationController
{

    /**
     * @Route ("translations", name="translations", methods="GET")
     * @Request ({"filter": "array", "page": "int"})
     * @param array $filter
     * @param int $page
     * @return array
     */
    public function translationsAction($filter = null, $page = 0)
    {
        return [
            '$view' => [
                'title' => __('Translations'),
                'name' => 'bixie/languagemanager/admin/translations.php'
            ],
            '$data' => [
                'languages' => App::module('bixie/languagemanager')->getActiveLanguages(),
                'types' => App::get('translationtypes')->all(),
                'config' => [
                    'filter' => (object) $filter,
                    'page' => $page
                ]
            ]
        ];
    }

    /**
     * @Route ("translation/edit", name="translation/edit")
     * @Request ({"id": "int"})
     * @param int $id
     * @return array
     */
    public function editAction($id = 0)
    {
        if (!$translation = Translation::find($id)) {
            if ($id == 0) {
                $translation = Translation::create();
            }
        }
        if (!$translation) {
            App::abort(404, __('Translation not found'));
        }
        return [
            '$view' => [
                'title' => __('Translation'),
                'name' => 'bixie/languagemanager/admin/translation.php'
            ],
            '$data' => [
                'languages' => App::module('bixie/languagemanager')->getActiveLanguages(),
                'types' => App::get('translationtypes')->all(),
                'translation' => $translation
            ],
            'translation' => $translation
        ];
    }


}

