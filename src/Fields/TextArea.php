<?php


namespace StuntDouble\Fields;


class TextArea extends Base
{
	public const FIELD = 'textarea';

	/**
	 * Get text.
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->faker->realText();
	}

}
