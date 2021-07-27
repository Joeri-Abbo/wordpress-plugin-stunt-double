<?php


namespace StuntDouble\Fields;


class Image extends Base
{
	public const FIELD = 'image';

	public function getValue()
	{
//		$this->faker->imageUrl(640, 480, 'animals', true);
		//https://developer.wordpress.org/reference/functions/wp_insert_attachment/
		return '';
	}

}
