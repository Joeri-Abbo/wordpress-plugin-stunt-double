<?php


namespace StuntDouble\Fields;


class Link extends Base
{
	public const FIELD = 'link';

	/**
	 * Get value for field.
	 * @return array
	 */
	public function getValue(): array
	{
		return [
			'url'   => $this->faker->url(),
			'title' => 'More information',
		];
	}
}
