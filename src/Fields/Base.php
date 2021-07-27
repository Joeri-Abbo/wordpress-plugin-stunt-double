<?php


namespace StuntDouble\Fields;


class Base
{
	protected $faker;

	public const FIELD = 'false';

	public function __construct($field, $faker)
	{
		$this->faker = $faker;
		$this->field = $field;
	}

	protected function strContains(string $string, string $needle): bool
	{
		return strpos($string, $needle) !== false;
	}

	protected function nameContains(string $needle): bool
	{
		return $this->strContains($this->field['name'], $needle);
	}

	public function getValue()
	{

		return $this->faker->words(4, true);

	}

}
