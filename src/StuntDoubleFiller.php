<?php

namespace StuntDouble;

use Faker\Factory;

class StuntDoubleFiller
{
	private $post_type;
	private $amount;
	private $faker;
	private $fields;

	public function __construct($post_type, $amount)
	{
		$this->post_type = $post_type;
		$this->amount    = $amount;
	}

	public function startFiller()
	{
		if ( ! $this->validatePostType()) {
			\WP_CLI::error(sprintf(__('%s was not a valid post_type. Choose one of these %s', STUNTDOUBLE_TEXT_DOMAIN),
				$this->post_type, implode(' ', $this->getPostTypes())));
		}

		$this->setupFaker();
		$this->getFieldModels();

		$this->insertPosts();

	}

	private function setupFaker()
	{
		$this->faker = Factory::create('nl_NL');
	}

	private function insertPosts()
	{

		$amount = 1;
		while ($amount <= $this->amount) {

			$this->insertPost();
			$amount++;
		}
	}

	private function insertPost()
	{
		$post_id = $this->setupBasePost();
//		$post_id = 177;
		$post = new BaseModel(get_post($post_id));

		$groups = acf_get_field_groups(['post_type' => $post->getType()]);

		if ( ! empty($groups)) {
			foreach ($groups as $group) {
				$fields = acf_get_fields($group['key']);

				if ( ! empty($fields)) {

					foreach ($fields as $field) {
						if (key_exists($field['type'], $this->fields)) {
							$fieldModel = new $this->fields[$field['type']]($field, $this->faker);
							$post->updateField($field['name'], $fieldModel->getValue());
						}
					}
				}
			}
		}
	}

	/**
	 * Get the Layouts
	 * @return array|false
	 */
	private function getFieldModels()
	{
		$fields = array_diff(scandir(STUNTDOUBLE_PATH . 'src/Fields'), array('.', '..'));
		if (empty($fields)) {
			return false;
		}
		$fields = $this->unsetValueOfArray('index.php', $fields);
		$fields = $this->stripPartOfArrayValue('.php', $fields);


		$this->fields = $this->getClasses('StuntDouble\Fields\\', $fields);
	}


	/**
	 * Unset item by value
	 *
	 * @param string $value
	 * @param array $items
	 *
	 * @return array
	 */
	private function unsetValueOfArray(string $value, array $items): array
	{
		if (($key = array_search($value, $items)) !== false) {
			unset($items[$key]);
		}

		return $items;
	}

	/**
	 * Strip part of value in array
	 *
	 * @param string $value
	 * @param array $items
	 *
	 * @return array
	 */
	private function stripPartOfArrayValue(string $value, array $items): array
	{
		foreach ($items as &$item) {
			$item = str_replace($value, '', $item);

		}

		return array_values($items);
	}

	/**
	 * Generate the classes
	 *
	 * @param string $namespace
	 * @param array $classes
	 *
	 * @return array
	 */
	private function getClasses(string $namespace, array $classes): array
	{
		$items = [];
		foreach ($classes as $class) {
			$c = $namespace . $class;
			if (class_exists($c)) {
				$items[$c::FIELD] = $c;
			}
		}

		return $items;
	}

	private function setupBasePost()
	{
		return wp_insert_post([
			'post_title'  => 'Faker: ' . $this->faker->words(3, true),
			'post_status' => 'publish',
			'post_type'   => $this->post_type
		]);
	}

	private function validatePostType()
	{
		return in_array($this->post_type, $this->getPostTypes());
	}

	public function getPostTypes()
	{
		$post_types = get_post_types();
		unset($post_types['acf-field']);
		unset($post_types['acf-field-group']);
		unset($post_types['wp_block']);
		unset($post_types['user_request']);
		unset($post_types['oembed_cache']);
		unset($post_types['customize_changeset']);
		unset($post_types['custom_css']);
		unset($post_types['nav_menu_item']);
		unset($post_types['revision']);

		return $post_types;
	}
}
