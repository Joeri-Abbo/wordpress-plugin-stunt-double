<?php

namespace StuntDouble\Fields;

class FlexibleContent extends Base
{
	public const FIELD = 'flexible_content';
	protected $fields;

	/**
	 * Get value for field
	 * @return array
	 */
	public function getValue(): array
	{
		$this->getFieldModels();
		$amount = rand(3, 8);
		$i      = 1;
		$data   = [];

		while ($i <= $amount) {
			$i++;

			$data[] = $this->getLayoutData();
		}

		return $data;
	}

	/**
	 * Generate data of for random layout
	 * @return array
	 */
	public function getLayoutData(): array
	{
		$layouts = $this->field['layouts'];
		shuffle($layouts);

		$layout = $layouts[0];
		$data['acf_fc_layout'] = $layout['name'];
		if ( ! empty($layout['sub_fields'])) {
			if ( ! empty($layout['sub_fields'])) {
				foreach ($layout['sub_fields'] as $field) {
					if ( ! empty($field['type'])) {
						if (key_exists($field['type'], $this->fields)) {
							$fieldModel          = new $this->fields[$field['type']]($field, $this->faker);
							$data[$field['key']] = $fieldModel->getValue();
						}
					}
				}
			}
		}

		return $data;
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
}
