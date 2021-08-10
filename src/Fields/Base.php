<?php


namespace StuntDouble\Fields;


use Faker\Factory;

class Base
{
	/**
	 * @var Factory faker of factory.
	 */
	protected $faker;

	/**
	 * Field name
	 */
	public const FIELD = 'false';
	/**
	 * @var int
	 */
	protected $post_id;
	/**
	 * @var array
	 */
	protected $field;

	public function __construct(array $field, $faker, int $post_id = null)
	{
		$this->faker   = $faker;
		$this->field   = $field;
		$this->post_id = $post_id;
	}

	/**
	 * Check if string contains needle
	 * @param string $string
	 * @param string $needle
	 *
	 * @return bool
	 */
	protected function strContains(string $string, string $needle): bool
	{
		return strpos($string, $needle) !== false;
	}

	/**
	 * Check if name contains string
	 * @param string $needle
	 *
	 * @return bool
	 */
	protected function nameContains(string $needle): bool
	{
		return $this->strContains($this->field['name'], $needle);
	}

	/**
	 * Get value for field
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->faker->words(4, true);
	}

	/**
	 * Get random bool
	 * @return mixed
	 */
	public function getRandomBool()
	{
		return $this->faker->boolean();
	}

	/**
	 * Get post_types
	 * @return mixed
	 */
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
		unset($post_types['attachment']);

		return $post_types;
	}

	/**
	 * Unset item by value
	 *
	 * @param string $value
	 * @param array $items
	 *
	 * @return array
	 */
	protected function unsetValueOfArray(string $value, array $items): array
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
	public function stripPartOfArrayValue(string $value, array $items): array
	{
		foreach ($items as &$item) {
			$item = str_replace($value, '', $item);
		}

		return array_values($items);
	}

	/**
	 * Get the Layouts
	 * @return void
	 */
	public function getFieldModels(): void
	{
		$fields = array_diff(scandir(STUNTDOUBLE_PATH . 'src/Fields'), array('.', '..'));
		if (empty($fields)) {
			return;
		}
		$fields = $this->unsetValueOfArray('index.php', $fields);
		$fields = $this->stripPartOfArrayValue('.php', $fields);


		$this->fields = $this->getClasses('StuntDouble\Fields\\', $fields);
	}

	/**
	 * Generate the classes
	 *
	 * @param string $namespace
	 * @param array $classes
	 *
	 * @return array
	 */
	protected function getClasses(string $namespace, array $classes): array
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

}
