<?php

namespace StuntDouble\Tests\Fields;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use StuntDouble\Fields\Number;

class NumberTest extends TestCase
{
    private function makeNumber(array $fieldOverrides = []): Number
    {
        $faker = Factory::create();
        $field = array_merge(['name' => 'count', 'min' => 1, 'max' => 50, 'step' => null], $fieldOverrides);
        return new Number($field, $faker, 1);
    }

    public function testGetValueWithinRange(): void
    {
        $number = $this->makeNumber(['min' => 5, 'max' => 10, 'step' => null]);
        $value = $number->getValue();
        $this->assertGreaterThanOrEqual(5, $value);
        $this->assertLessThanOrEqual(10, $value);
    }

    public function testGetValueWithStep(): void
    {
        $number = $this->makeNumber(['min' => 1, 'max' => 5, 'step' => 2]);
        $value = $number->getValue();
        $this->assertIsInt($value);
    }

    public function testGetValueDefaultRange(): void
    {
        $number = $this->makeNumber(['min' => null, 'max' => null, 'step' => null]);
        $value = $number->getValue();
        $this->assertGreaterThanOrEqual(0, $value);
        $this->assertLessThanOrEqual(100, $value);
    }
}
