<?php

namespace StuntDouble;

use Faker\Factory;

class StuntDoubleFiller
{
	/**
	 * @var string $post_type post_type to seed
	 */
	private $post_type;
	/**
	 * @var int $amount amount of posts
	 */
	private $amount;
	/**
	 * @var Factory $faker factory for faker
	 */
	private $faker;
	/**
	 * @var array $fields fields
	 */
	private $fields;

	public function __construct($post_type, $amount)
	{
		$this->post_type = $post_type;
		$this->amount    = $amount;
	}

	/**
	 * Start filler
	 */
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

	/**
	 * Setup faker
	 */
	private function setupFaker()
	{
		$this->faker = Factory::create('nl_NL');
	}

	/**
	 * insert amount of posts
	 */
	private function insertPosts()
	{
		$amount = 1;
		while ($amount <= $this->amount) {
			$this->insertPost();
			$amount++;
		}
	}

	/**
	 * Insert new post
	 */
	private function insertPost()
	{
		$groups = acf_get_field_groups(['post_type' => $this->post_type]);
		$amount = 1;
		foreach ($groups as $group) {
			$amount = $amount + count(acf_get_fields($group['key']));
		}

		$progress = \WP_CLI\Utils\make_progress_bar('Adding new post progress = ', $amount);

		$post_id = $this->setupBasePost();
		\WP_CLI::line(__('Adding new post id is ', \stuntDouble::STUNTDOUBLE_TEXT_DOMAIN) . $post_id);

		$progress->tick();

		$post = new BaseModel(get_post($post_id));

		if ( ! empty($groups)) {

			foreach ($groups as $group) {
				$fields = acf_get_fields($group['key']);
				if ( ! empty($fields)) {
					foreach ($fields as $field) {
						if (key_exists($field['type'], $this->fields)) {
							$fieldModel = new $this->fields[$field['type']]($field, $this->faker, $post_id);
							$post->updateField($field['name'], $fieldModel->getValue());

						} elseif ($field['type'] === 'message' || $field['type'] === 'accordion' || $field['type'] === 'tab') {
							// do nothing no filling allowed
						}
						$progress->tick();
					}
				}
			}
		}
		$progress->finish();
		\WP_CLI::line(__('Post is finished with id ', \stuntDouble::STUNTDOUBLE_TEXT_DOMAIN) . $post_id);


	}

	/**
	 * Get the Layouts
	 * @return void
	 */
	private function getFieldModels(): void
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

	/**
	 * Setup base post
	 * @return mixed
	 */
	private function setupBasePost()
	{
		global $_wp_post_type_features;

		$data = [
			'post_title'  => 'Faker: ' . $this->faker->words(3, true),
			'post_status' => 'publish',
			'post_type'   => $this->post_type,
		];
		if ( ! empty($supports = $_wp_post_type_features[$this->post_type])) {

			if (isset($supports['editor'])) {
				$data['post_content'] = $this->faker->paragraph;
			}
			if (isset($supports['excerpt'])) {
				$data['post_excerpt'] = $this->faker->paragraph(2);
			}
//			dd($supports);
			// Todo Add more supports
		}

		return wp_insert_post($data);
	}

	/**
	 * Check if post_type exists
	 * @return bool
	 */
	private function validatePostType(): bool
	{
		return in_array($this->post_type, $this->getPostTypes());
	}

	/**
	 * Get post_Types without default post_types
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
}
