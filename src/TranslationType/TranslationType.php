<?php

namespace Bixie\Languagemanager\TranslationType;

use Pagekit\Application as App;
use Pagekit\Util\Arr;


class TranslationType implements \JsonSerializable {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $label;

	/**
	 * @var string
	 */
	public $model;

	/**
	 * @var string
	 */
	public $event_model;

	/**
	 * @var string
	 */
	public $edit_link;

	/**
	 * @var bool
	 */
	public $allow_manual = true;

	/**
	 * Emailtype constructor.
	 * @param string $name
	 * @param array  $data
	 */
	public function __construct ($name, array $data) {
		$this->name = $name;
		foreach (get_object_vars($this) as $key => $default) {
			$this->$key = Arr::get($data, $key, $default);
		}
	}

	/**
	 * @return string
	 */
	public function getName () {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getEventModel () {
		return $this->event_model ?: strtolower(basename($this->model));
	}

	/**
	 * @param array $data
	 * @param array $ignore
	 * @return array
	 */
	public function toArray ($data = [], $ignore = []) {
		return array_diff_key(array_merge([
			'name' => $this->name,
			'label' => $this->label ? : $this->name,
			'model' => $this->model,
			'edit_link' => $this->edit_link,
		], $data), array_flip($ignore));
	}

	/**
	 * @return array
	 */
	function jsonSerialize () {
		return $this->toArray();
	}


}