<?php

namespace StuntDouble;


/**
 *
 * Create the base model.
 * This can be extended for the post_types that need this model
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class BaseModel
{

	/**
	 * @var WP_Post|\WP_Post
	 */
	protected $post;
	/**
	 * Permalink
	 * @var string
	 */
	protected $_link;

	/**
	 * Product constructor.
	 *
	 * @param \WP_Post $post Post
	 */
	public function __construct($post)
	{
		$this->post = $post;
	}

	/**
	 * Get the post object
	 * @return WP_Post|\WP_Post
	 */
	public function getPost()
	{
		return $this->post;
	}

	/**
	 * Return post id
	 * @return int
	 */
	public function getId(): int
	{
		return $this->getPost()->ID;
	}

	/**
	 * Get the post title of the post.
	 */
	public function getPostTitle()
	{
		return $this->getPost()->post_title;
	}

	/**
	 * Set the post title of the post.
	 */
	public function setPostTitle(string $status)
	{
		$this->updateDefaultPostValue('post_title', $status);
	}

	/**
	 * Get the post status of the post.
	 * @return string
	 */
	public function getPostStatus(): string
	{
		return $this->getPost()->post_status;
	}

	/**
	 * Set the post status of the post.
	 */
	public function setPostStatus($status)
	{
		$this->updateDefaultPostValue('post_status', $status);
	}

	/**
	 * Get the post_type of post
	 * @return string
	 */
	public function getType(): string
	{
		return $this->getPost()->post_type;
	}

	/**
	 * Get the post_type of post
	 * @return string
	 */
	public function getPostType(): string
	{
		return $this->getType();
	}

	/**
	 * Get the post_type of post
	 *
	 * @param string $post_type
	 *
	 * @return string
	 */
	public function setPostType(string $post_type): string
	{
		$this->updateDefaultPostValue('post_type', $post_type);
	}

	/**
	 * Get the permalink of the post
	 * @return mixed
	 */
	public function getPermalink()
	{
		if ( ! $this->_link) {
			$this->_link = get_the_permalink($this->post);
		}

		return $this->_link;
	}

	/**
	 * Get the post_type of post
	 * @return string
	 */
	public function getLink(): string
	{
		return $this->getPermalink();
	}

	/**
	 * Function over the default wp_update_post to make it easier to update data.
	 *
	 * @param string $key
	 * @param $value
	 */
	protected function updateDefaultPostValue(string $key, $value)
	{
		wp_update_post([
			'ID' => $this->post->ID,
			$key => $value
		]);
	}

	/**
	 * Function over the default update_post_meta to make it easier to update data.
	 *
	 * @param string $key
	 * @param $value
	 */
	protected function updatePostMetaValue(string $key, $value): void
	{
		update_post_meta($this->getId(), $key, $value);
	}

	/**
	 * Function over the default get_post_meta to make it easier to update data.
	 *
	 * @param string $key
	 * @param bool $single
	 *
	 * @return mixed
	 */
	protected function getPostMetaValue(string $key, $single = true)
	{
		return get_post_meta($this->getId(), $key, $single);
	}

	/**
	 * Get field of current post
	 *
	 * @param $selector
	 *
	 * @return mixed
	 */
	public function getField($selector)
	{
		return get_field($selector, $this->getId());
	}

	/**
	 * Set value for field of current post
	 *
	 * @param string $selector
	 * @param $value mixed
	 *
	 * @return mixed
	 */
	public function updateField(string $selector, $value)
	{
		return update_field($selector, $value, $this->getId());
	}

	/**
	 * Get fields of current post
	 *
	 * @return mixed
	 */
	public function getFields()
	{
		return get_fields($this->getId());
	}

}
