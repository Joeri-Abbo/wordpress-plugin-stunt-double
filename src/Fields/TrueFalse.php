<?php


namespace StuntDouble\Fields;


class TrueFalse extends Base
{
	public const FIELD = 'true_false';

	/**
	 * Get value
	 * @return bool
	 */
	public function getValue(): bool
	{
		return $this->getRandomBool();
	}
}
