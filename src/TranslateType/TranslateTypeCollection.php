<?php


namespace Bixie\Languagemanager\TranslateType;


class TranslateTypeCollection implements \IteratorAggregate, \Countable {

	/**
	 * @var TranslateType[]
	 */
	protected $types;

	/**
	 * Constructor.
	 * @param array $types
	 */
	public function __construct (array $types = []) {
		foreach ($types as $name => $data) {
			$this->add(new TranslateType($name, $data));
		}
	}

	/**
	 * Gets pricefactor from collection.
	 * @param  string $name
	 * @return TranslateType
	 */
	public function get ($name) {
		return isset($this->types[$name]) ? $this->types[$name] : null;
	}

	/**
	 * Registers types to collection.
	 * @param array $types
	 */
	public function register ($types) {
		foreach ((array) $types as $name => $data) {
			$this->add(new TranslateType($name, $data));
		}
	}

	/**
	 * Adds type to collection.
	 * @param TranslateType $type
	 */
	public function add (TranslateType $type) {
		$this->types[$type->getName()] = $type;
	}

	/**
	 * @return TranslateType[]
	 */
	public function all () {
		return $this->types;
	}

	/**
	 * Removes types from collection.
	 * @param string|array $name
	 */
	public function remove ($name) {
		$names = (array)$name;

		foreach ($names as $name) {
			unset($this->types[$name]);
		}
	}

	/**
	 * Countable interface implementation.
	 * @return int
	 */
	public function count () {
		return count($this->types);
	}

	/**
	 * IteratorAggregate interface implementation.
	 * @return \ArrayIterator
	 */
	public function getIterator () {
		return new \ArrayIterator($this->types);
	}
}