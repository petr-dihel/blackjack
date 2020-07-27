<?php
/**
 * Created by PhpStorm.
 * User: Petr
 * Date: 17.02.2019
 * Time: 12:48
 */

class CardPack {

    /**
     * @var int
     */
    const LOW_ACE_VALUE = 1;

    /**
     * @var int
     */
    const FACE_VALUE = 10;

	/**
	 * @var int
	 */
	const NUMBER_OF_CARDS = 13;

	/**
	 * @var int
	 */
	const LOWEST_FACE_CARD = 11;

	/**
	 * @vat array
	 */
	//const faces = array('JACK', 'QUEEN', 'KING'); PHP 5.6 +
	private $faces = array('JACK', 'QUEEN', 'KING');

	/**
	 * @var string
	 */
	private $color = "";

	/**
	 * @var Card[]|array
	 */
	private $cards = array();

	/**
	 * @return string
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * @param string $color
	 * @return CardPack
	 */
	public function setColor($color) {
		$this->color = $color;
		return $this;
	}

	/**
	 * @return array|Card[]
	 */
	public function generateCards() {
		$addedAce = false;
		for ($i = 1; $i <= self::NUMBER_OF_CARDS; ++$i) {
			$tmpName = $this->color . ' ';

			if ($i >= self::LOWEST_FACE_CARD) {
				$tmpName .= $this->faces[$i - self::LOWEST_FACE_CARD];
				$value = self::FACE_VALUE;
			} elseif (!$addedAce) {
				$tmpName .= 'ACE';
				$value = self::LOW_ACE_VALUE;
			} else {
				$tmpName .= $i;
				$value = $i;
			}
			$card = new Card();
			$card->setValue($value);
			$card->setName($tmpName);
			$card->setIsAce(!$addedAce);
			$addedAce = true;
			$this->cards[] = $card;
		}
		return $this->cards;
	}

	public function shuffle() {
		shuffle($this->cards);
	}

	/**
	 * @param Card[] $cards
	 * @return $this
	 */
	public function setCards($cards) {
		$this->cards = $cards;
		return $this;
	}

	/**
	 * @return array|Card[]
	 */
	public function getCards() {
		return $this->cards;
	}

	/**
	 * @return Card
	 */
	public function getCard() {
		return array_shift($this->cards);
	}
}