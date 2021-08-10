<?php


namespace StuntDouble\Fields;


class Wysiwyg extends Base
{
	public const FIELD = 'wysiwyg';

	/**
	 * Get value for field.
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->faker->realText();
	}

}
