<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BlackJack</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
			integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
			crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
			integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
			crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
			integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
			crossorigin="anonymous"></script>
</head>
<body>
<?php
require_once 'GameOverException.php';
require_once 'DoubleAceException.php';
require_once 'PlayDeck.php';
require_once 'Card.php';
require_once 'CardPack.php';
require_once 'Player.php';

$playDeck = new PlayDeck();
echo 'Shuffling deck <br/>';
$playDeck->shuffle();
/** @var Player[] $players */
$players = array(
	new Player('Minařík'),
	new Player('Olik'),
	new Player('Asiat1'),
	new Player('Asiat2'),
	new Player('Ojebavač', true)
);

echo '<h2>Players: </h2><br/>';
?>
<table class="table table-striped ">
	<tbody>
	<?php
	foreach ($players as $player) {
		echo '<tr><td>' . ($player->isDealer() ? 'Dealer - ' : '') . $player->getName() . '</td></tr>';
	}
	?>
	</tbody>
</table>
<?php
echo 'Game starts: <br/>';
echo '--------------------------<br/>';
$dealerDoubleAce = false;
$dealerScore = 0;
foreach ($players

as $player) {
echo '<h2>' . ($player->isDealer() ? 'Dealer - ' : 'Player ') . $player->getName() . '</h2>';
try {
?>
<table class="table table-striped">

	<?php
	while ($player->isWantNextCard()) {
		$card = $playDeck->getCard();
		echo '<tr><td>Card is: ' . $card->getName() . ' - ';
		$player->addCard($card);
		echo 'Sum is: ' . $player->getSum() . '</tr></td>';
	}
	echo '<tr class=""><td class="alert alert-info">Player does not want next card</tr></td>';
	if ($player->isDealer()) {
		$dealerScore = $player->getSum();
	}
	} catch (GameOverException $exception) {
		if ($player->isDealer()) {
			if (get_class($exception) == DoubleAceException::getClassName()) {
				$dealerDoubleAce = true;
			}
			$dealerScore = 0;
		}
		echo '</tr></td><tr><td class="alert alert-danger">' . $exception->getMessage() . '</tr></td>';
	}
	echo '</table>';
	}

	/**
	 * @param string $player
	 * @param int $points
	 * @param bool $win
	 */
	function coutResult($player, $points, $win = true) {
		if ($win) {
			echo '<div class="alert alert-info">Player - ' . $player . ' - ' . $points. ' - wins </div>';
		} else {
			echo '<div class="alert alert-danger">Player - ' . $player . ' - ' . $points . ' - loses </div>';
		}
	}

	echo '<h2>Results</h2>';
	echo '<div class="alert alert-warning">Dealer points: ' . $dealerScore . '</div>';
	foreach ($players as $player) {
		if ($player->isDealer()) continue;
		try {
			$playerSum = $player->getSum();
			if ($dealerDoubleAce) {
				coutResult($player->getName(), $playerSum, false);
				continue;
			}
			if ($playerSum > $dealerScore) {
				coutResult($player->getName(), $playerSum, true);
			} elseif ($playerSum < $dealerScore) {
				coutResult($player->getName(), $playerSum, false);
			} else {
				echo '<div class="alert alert-warning">Player - ' . $player->getName() . ' - ' . $playerSum
					. ' - ties </div>';
			}
		} catch (GameOverException $exception) {
			if (get_class($exception) == DoubleAceException::getClassName()) {
				coutResult($player->getName(), $exception->getCardValuesSum(), true);
			} else {
				coutResult($player->getName(), $exception->getCardValuesSum(), false);
			}
		}
	}
	?>

</body>
</html>

