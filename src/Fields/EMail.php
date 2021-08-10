<?php

namespace StuntDouble\Fields;

class EMail extends Base
{
	public const FIELD = 'email';

	/**
	 * Get value for field
	 * @return string
	 */
	public function getValue()
	{
		return $this->faker->safeEmail;
	}
}
