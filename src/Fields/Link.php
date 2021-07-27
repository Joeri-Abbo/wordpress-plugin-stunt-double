<?php


namespace StuntDouble\Fields;


class Link extends Base
{
	public const FIELD = 'link';

	public function getValue()
	{
		return [
			'url'   => $this->faker->url(),
			'title' => 'More information',
		];
	}

}
