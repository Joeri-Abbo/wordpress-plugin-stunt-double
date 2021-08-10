<?php


namespace StuntDouble\Fields;

class PostObject extends Base
{
	public const FIELD = 'post_object';

	/**
	 * Get value for field
	 * @return false|mixed
	 */
	public function getValue()
	{
		return $this->getRandomPosts();
	}

	/**
	 * Get random post of post_type
	 *
	 * @param int $posts_per_page
	 *
	 * @return int|null
	 */
	public function getRandomPosts(int $posts_per_page = 1): ?int
	{
		$post_types = $this->field['post_type'] ?: $this->getPostTypes();
		$args       = [
			'post_type'      => array_values($post_types),
			'posts_per_page' => $posts_per_page,
			'orderby'        => 'rand',
			'order'          => 'ASC'
		];

		$posts      = get_posts($args);

		if (empty($posts)) {
			return false;
		}

		return wp_list_pluck($posts, 'ID')[0];
	}
}
