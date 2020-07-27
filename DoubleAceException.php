<?php

class DoubleAceException extends GameOverException {

	public static function getClassName() {
		return get_called_class();
	}
}