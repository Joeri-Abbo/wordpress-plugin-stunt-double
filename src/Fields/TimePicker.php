<?php

namespace StuntDouble\Fields;

class TimePicker extends DatePicker
{
	public const FIELD = 'time_picker';

	/**
	 * Get random time
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->getRandomDate('H:i:s');
	}
}
