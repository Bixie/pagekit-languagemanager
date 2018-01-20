<?php

namespace Bixie\Languagemanager\Model;

use Bixie\Languagemanager\TranslationType\TranslationType;
use Pagekit\Application\UrlProvider;
use Pagekit\System\Model\DataModelTrait;
use Pagekit\Application as App;

/**
 * @Entity
 * (tableClass="@languagemanager_translation",eventPrefix="languagemanager_translation")
 */
class Translation implements \JsonSerializable
{

    use TranslationModelTrait, DataModelTrait;

    /**
     * @Column (type="integer") @Id
     * @var int
     */
    public $id = null;

    /**
     * @Column (type="string")
     * @var string
     */
    public $type = '';

    /**
     * @Column (type="integer")
     * @var int
     */
    public $model_id = null;

    /**
     * @Column (type="string")
     * @var string
     */
    public $model = '';

    /**
     * @Column (type="string")
     * @var string
     */
    public $language = '';

    /**
     * @Column (type="string")
     * @var string
     */
    public $title = '';

    /**
     * @Column (type="string")
     * @var string
     */
    public $content = '';

    /**
     * @var TranslationType
     */
    protected $translationType;

    /** @var array */
    protected static $properties = [
        'model_url' => 'getModelUrl',
    ];

    /**
     * @return TranslationType
     */
    public function getTranslationType () {
        if (!isset($this->translationType)) {
            $this->translationType = App::get('translationtypes')->get($this->type);
        }
        return $this->translationType;
    }

    public function getModelUrl ($referenceType = UrlProvider::BASE_PATH) {
        if ($link = $this->getTranslationType()->edit_link) {
            return App::url($link, ['id' => $this->model_id], $referenceType);
        }
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize () {
        return $this->toArray([], ['translationType']);
    }


}

