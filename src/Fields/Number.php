<?php


namespace StuntDouble\Fields;


class Number extends Base
{
	public const FIELD = 'number';

	public function getValue()
	{
		$min  = $this->field['min'];
		$max  = ! empty($this->field['max']) ? $this->field['max'] : 1000;
		$step = $this->field['step'];
		if ( ! empty($step)) {
			return rand($min * 2, $max * 2) * $step;
		} else {
			return rand($min, $max);
		}

	}

}
