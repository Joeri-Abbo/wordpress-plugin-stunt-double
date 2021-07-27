<?php


namespace StuntDouble\Fields;


class Text extends Base
{
	public const FIELD = 'text';

	public function getValue()
	{

		if ($this->nameContains('name')) {
			if ($this->nameContains('company')) {
				return $this->faker->company;
			} elseif ($this->nameContains('first_name')) {
				return $this->faker->firstName();
			} elseif ($this->nameContains('last_name')) {
				return $this->faker->lastName();
			}

			return $this->faker->name;
		}

		if ($this->nameContains('function') || $this->nameContains('job')) {
			return $this->faker->jobTitle;
		}

		if ($this->nameContains('company')) {
			return $this->faker->company;
		}

		return $this->faker->words(4, true);
	}

}
