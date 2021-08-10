<?php


namespace StuntDouble\Fields;

class User extends Base
{
	public const FIELD = 'user';

	/**
	 * Get data for field.
	 * @return mixed|null
	 */
	public function getValue()
	{
		return $this->getRandomUser();
	}

	/**
	 * Get random user
	 * @return mixed
	 */
	public function getRandomUser()
	{
		$users = get_users([
			'orderby'        => 'rand',
			'posts_per_page' => 1,
			'order'          => 'ASC'
		]);

		if (empty($users)) {
			return null;
		}

		shuffle($users);

		return $users[0];
	}
}
