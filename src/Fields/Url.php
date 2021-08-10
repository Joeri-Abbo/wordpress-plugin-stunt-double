<?php


namespace StuntDouble\Fields;


class Url extends Base
{
	public const FIELD = 'url';

	/**
	 * Get url value for this field
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->faker->url();
	}
}
