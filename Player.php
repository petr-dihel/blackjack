<?php

class Player {

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var bool
	 */
	private $isDealer = false;

	/**
	 * @var Card[]|array
	 */
	private $cardsInHand = array();

	/**
	 * Player constructor.
	 * @param string $name
	 * @param bool $isDealer
	 */
	public function __construct($name, $isDealer = false) {
		$this->name = $name;
		$this->isDealer = $isDealer;
	}

	/**
	 * @return bool
	 */
	public function isDealer() {
		return $this->isDealer;
	}

	/**
	 * @param bool $isDealer
	 * @return Player
	 */
	public function setIsDealer($isDealer) {
		$this->isDealer = $isDealer;
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
	 * @return Player
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return bool
	 * @throws GameOverException
	 */
	public function isWantNextCard() {
		if ($this->getSum() == 21) {
			return false;
		}
		if ($this->isDealer) {
			return ($this->getSum() < 17);
		}
		if ($this->getSum() <= 10) {
			return true;
		}
		$chanceOfTakingNextCard = (10 / ($this->getSum() * 1.4)) * 100;
		$rand = rand(0, 100);
		if ($rand <= $chanceOfTakingNextCard) {
			return true;
		}
		return false;
	}

	/**
	 * @return int
	 * @throws GameOverException
	 */
	public function getSum() {
		$aces = array();
		$sum = 0;
		foreach ($this->cardsInHand as $card) {
			if ($card->isAce()) {
				$aces[] = $card;
				continue;
			}
			$sum += $card->getValue();
		}
		foreach ($aces as $ace) {
			if (($sum == 11 && count($aces) == 2 && count($this->cardsInHand) == 2)) {
				throw new DoubleAceException('Double Ace');
			}
			if ($sum < 11) {
				$sum += 11;
			} else {
				$sum += 1;
			}
		}
		if ($sum > 21) {
			throw (new GameOverException('Over 21'))->setCardValuesSum($sum);
		}
		return $sum;
	}

	/**
	 * @param Card $card
	 */
	public function addCard($card) {
		$this->cardsInHand[] = $card;
	}
}