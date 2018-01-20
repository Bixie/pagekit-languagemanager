<?php

namespace Bixie\Languagemanager\Model;

use Pagekit\System\Model\DataModelTrait;

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


}

