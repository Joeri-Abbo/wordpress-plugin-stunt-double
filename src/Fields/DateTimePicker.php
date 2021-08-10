<?php

namespace StuntDouble\Fields;

class DateTimePicker extends DatePicker
{
	public const FIELD = 'date_time_picker';

	/**
	 * Get value for field
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->getRandomDate('Y-m-d H:i:s');
	}
}
