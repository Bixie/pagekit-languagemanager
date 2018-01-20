<?php

namespace Bixie\Languagemanager\Controller;

use Pagekit\Application as App;
use Pagekit\Application\Exception;
use Bixie\Languagemanager\Model\Translation;

/**
 * Translation Api Controller
 *
 * @Route ("translation", name="translation")
 */
class TranslationApiController
{

    /**
     * @Route ("/", methods="GET")
     * @Request ({"filter": "array", "page": "int"})
     * @param array $filter
     * @param int $page
     * @return array
     */
    public function indexAction($filter = null, $page = 0)
    {
        $query = Translation::query();
        $filter = array_merge(array_fill_keys(['order', 'type', 'model', 'model_id', 'language', 'limit', 'search'], ''), (array)$filter);
        extract($filter, EXTR_SKIP);

        if ($type) $query->where('type = :type', ['type' => $type]);
        if ($model) $query->where('model = :model', ['model' => $model]);
        if ($model_id) $query->where('model_id = :model_id', ['model_id' => $model_id]);
        if ($language) $query->where('language = :language', ['language' => $language]);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere(['title LIKE :search', 'content LIKE :search'], ['search' => "%{$search}%"]);
            });
        }
        if (!preg_match('/^(id|type|model_id|model|language|title|content)\s(asc|desc)$/i', $order, $order)) {
            $order = [1 => 'title', 2 => 'asc'];
        }

        $limit = (int)$limit ?: 20;
        $count = $query->count();
        $pages = ceil($count / $limit);
        $page = max(0, min($pages - 1, $page));

        $translations = array_values($query->offset($page * $limit)->limit($limit)->orderBy($order[1], $order[2])->get());

        return compact('translations', 'pages', 'count');
    }

    /**
     * @Route ("/", methods="POST")
     * @Route ("/{id}", methods="POST", requirements={"id"="\d+"})
     * @Request ({"translation": "array", "id": "int"}, csrf=true)
     * @param array $data
     * @param int $id
     * @return array
     */
    public function saveAction($data, $id = 0)
    {
        if (!$translation = Translation::find($id)) {
            $translation = Translation::create();
            unset($data['id']);
        }
        try {

            $translation->save($data);

        } catch (Exception $e) {
            App::abort(400, $e->getMessage());
        }
        return ['message' => 'success', 'translation' => $translation];
    }

    /**
     * @Route ("/bulk", methods="POST")
     * @Request ({"translations": "array"}, csrf=true)
     * @param array $translations
     * @return array
     */
    public function bulkSaveAction($translations = [])
    {
        $saved = [];
        foreach ($translations as $data) {
            $ret = $this->saveAction($data, isset($data['id']) ? intval($data['id']) : 0);
            $saved[] = $ret['translation'];
        }

        return ['translations' => $saved];
    }

    /**
     * @Route ("/{id}", methods="DELETE", requirements={"id"="\d+"})
     * @Request ({"id": "int"}, csrf=true)
     * @param int $id
     * @return array
     */
    public function deleteAction($id = 0)
    {
        if ($translation = Translation::find($id)) {
            $translation->delete();
        }
        return ['message' => 'success'];
    }

    /**
     * @Route ("/bulk", methods="DELETE")
     * @Request ({"ids": "array"}, csrf=true)
     * @param array $ids
     * @return array
     */
    public function bulkDeleteAction($ids = [])
    {
        foreach (array_filter($ids) as $id) {
            $this->deleteAction($id);
        }

        return ['message' => 'success'];
    }


}

