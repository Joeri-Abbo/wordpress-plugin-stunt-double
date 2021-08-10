<?php


namespace StuntDouble\Fields;


class Select extends Base
{
	public const FIELD = 'select';

	/**
	 * Get value for field
	 * @return array|int|string
	 */
	public function getValue()
	{
		$multiple = $this->field['multiple'] ?? false;
		$choices  = $this->field['choices'];
		$multiple = $multiple ? 2 : 1;

		return array_rand($choices, $multiple);
	}
}
