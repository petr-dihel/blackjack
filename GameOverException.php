<?php

class GameOverException extends Exception {

	public $cardValuesSum;

	/**
	 * @return mixed
	 */
	public function getCardValuesSum() {
		return $this->cardValuesSum;
	}

	/**
	 * @param mixed $cardValuesSum
	 * @return GameOverException
	 */
	public function setCardValuesSum($cardValuesSum) {
		$this->cardValuesSum = $cardValuesSum;
		return $this;
	}

}