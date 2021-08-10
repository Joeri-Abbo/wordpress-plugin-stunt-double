<?php

namespace StuntDouble\Fields;

class Number extends Base
{
	public const FIELD = 'number';

	/**
	 * Get random number
	 * @return float|int|mixed
	 */
	public function getValue()
	{
		$min  = $this->field['min'] ?: 0;
		$max  = $this->field['max'] ?: 100;
		$step = $this->field['step'];
		if ( ! empty($step)) {
			return rand($min * 2, $max * 2) * $step;
		} else {
			return rand($min, $max);
		}
	}
}
