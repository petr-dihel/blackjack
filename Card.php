<?php

class Card {

	/**
	 * @var int
	 */
	const ACE = 1;

	/**
	 * @var string
	 */
	private $name = "";

	/**
	 * @var int
	 */
	private $value = 0;

	/**
	 * @var bool
	 */
	private $isAce = false;

	/**
	 * @return bool
	 */
	public function isAce() {
		return $this->isAce;
	}

	/**
	 * @param bool $isAce
	 * @return Card
	 */
	public function setIsAce($isAce) {
		$this->isAce = $isAce;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Card
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param int $value
	 * @return Card
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}

}