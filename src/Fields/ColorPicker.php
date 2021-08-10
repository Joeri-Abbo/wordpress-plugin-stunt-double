<?php

namespace StuntDouble\Fields;

class ColorPicker extends DatePicker
{
	public const FIELD = 'color_picker';

	/**
	 * Get value for field
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->faker->hexColor();
	}
}
