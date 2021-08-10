<?php

namespace StuntDouble\Fields;

class DatePicker extends Base
{
	public const FIELD = 'date_picker';

	/**
	 * Get value for field
	 * @return string
	 */
	public function getValue()
	{
		return $this->getRandomDate();
	}

	/**
	 * Get random date
	 *
	 * @param string $format
	 *
	 * @return string
	 */
	public function getRandomDate(string $format = 'Ymd'): string
	{
		return $this->faker->dateTimeThisDecade()->format($format);
	}
}
