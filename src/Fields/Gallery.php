<?php


namespace StuntDouble\Fields;


class Gallery extends Image
{
	public const FIELD = 'gallery';

	/**
	 * Get value for field
	 * @return array
	 */
	public function getValue(): array
	{
		$amount = rand(1, 6);
		$images = [];

		$min_width  = ! empty($this->field['min_width']) ? $this->field['min_width'] : null;
		$min_height = ! empty($this->field['min_height']) ? $this->field['min_height'] : null;

		foreach (range(1, $amount) as $index) {
			$images[] = $this->getImage($min_width, $min_height);
		}

		return $images;
	}
}
