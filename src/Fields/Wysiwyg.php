<?php


namespace StuntDouble\Fields;


class Wysiwyg extends Base
{
	public const FIELD = 'wysiwyg';

	public function getValue()
	{
		return $this->faker->paragraph;
	}

}
