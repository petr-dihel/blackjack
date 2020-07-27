<?php

class PlayDeck {

	/**
	 * @var int
	 */
	const NUMBER_OF_DECKS = 4;

	/**
	 * @var int
	 */
	private $numberOfCards = 0;

	/**
	 * @var Card[]|array
	 */
	private $playDeck = array();

	public function __construct() {
		$cards = (new CardPack())->setColor('black')->generateCards();
		$cards = array_merge($cards, (new CardPack())->setColor('red')->generateCards());
		$cards = array_merge($cards, (new CardPack())->setColor('white')->generateCards());
		$cards = array_merge($cards, (new CardPack())->setColor('blue')->generateCards());
		$this->playDeck = (new CardPack())->setCards($cards);
		$this->numberOfCards = CardPack::NUMBER_OF_CARDS * self::NUMBER_OF_DECKS;
	}

	public function shuffle() {
		$this->playDeck->shuffle();
	}

	/**
	 * @return Card
	 */
	public function getCard() {
		$card = $this->playDeck->getCard();
		$this->numberOfCards--;
		return $card;
	}

}