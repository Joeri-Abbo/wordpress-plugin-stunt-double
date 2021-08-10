<?php


namespace StuntDouble\Fields;


class Text extends Base
{
	public const FIELD = 'text';

	/**
	 * Get random text
	 * @return null|string
	 */
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

		if ($this->nameContains('quote')) {
			return $this->getQuote();
		}

		if ($this->nameContains('company')) {
			return $this->faker->company;
		}

		return $this->faker->words(4, true);
	}

	/**
	 * Get random quote
	 * @return mixed|null
	 */
	private function getQuote()
	{
		$data = file_get_contents('https://joeri-abbo.github.io/marvel-quotes/index.html');
		if (empty($data)) {
			return null;
		}

		$quotes     = json_decode($data, true);
		$random_key = array_rand($quotes, 1);

		return $quotes[$random_key]['url'];
	}

}
