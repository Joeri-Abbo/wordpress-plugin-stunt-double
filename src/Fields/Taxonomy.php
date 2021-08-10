<?php


namespace StuntDouble\Fields;

class Taxonomy extends Base
{
	public const FIELD = 'taxonomy';

	/**
	 * Get value for field
	 * @return false|mixed
	 */
	public function getValue()
	{
		return $this->getRandomTaxonomy();
	}

	/**
	 * Get random taxonomy
	 * @return WP_Term|null
	 */
	public function getRandomTaxonomy(): ?\WP_Term
	{
		$taxonomy = $this->field['taxonomy'];

		$terms = get_terms($taxonomy, [
			'hide_empty'     => false,
			'orderby'        => 'rand',
			'posts_per_page' => 1,
			'order'          => 'ASC'
		]);

		if (empty($terms)) {
			return null;
		}

		shuffle($terms);

		return $terms[0];
	}
}
