<?php


namespace StuntDouble\Fields;


class Repeater extends Base
{
	public const FIELD = 'repeater';
	protected $fields;

	/**
	 * Get value for field.
	 * @return array
	 */
	public function getValue(): array
	{
		$this->getFieldModels();
		$data = [];
		foreach (range(1, rand(0, 5)) as $index) {
			if ( ! empty($this->field['sub_fields'])) {
				foreach ($this->field['sub_fields'] as $field) {
					if ( ! empty($field['type'])) {
						if (key_exists($field['type'], $this->fields)) {
							$fieldModel                   = new $this->fields[$field['type']]($field, $this->faker);
							$data[$index][$field['name']] = $fieldModel->getValue();
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
