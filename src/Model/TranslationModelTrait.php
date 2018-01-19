<?php

namespace Bixie\Languagemanager\Model;

use Pagekit\Application as App;
use Pagekit\Database\ORM\ModelTrait;

trait TranslationModelTrait
{
	use ModelTrait {
		create as modelCreate;
	}

    /**
     * @param $model
     * @param $model_id
     * @param $language
     * @return Translation|null
     */
	public static function findModelTranslation ($model, $model_id, $language) {
	    $query = self::where(compact('model', 'model_id', 'language'));
		return $query->first();
	}

	/**
	 * @param array $data
	 * @return Translation
	 */
	public static function create ($data = []) {
		/** @var Translation $translation */
        $translation = self::modelCreate(array_merge([
			'data' => [
            ],
		], $data));
		return $translation;
	}

}
