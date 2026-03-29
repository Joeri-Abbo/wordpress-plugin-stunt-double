<?php

namespace StuntDouble\Tests\Fields;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use StuntDouble\Fields\Base;

class BaseTest extends TestCase
{
    private function makeBase(array $field = []): Base
    {
        $faker = Factory::create();
        return new Base($field ?: ['name' => 'test_field'], $faker, 1);
    }

    public function testGetValueReturnsString(): void
    {
        $base = $this->makeBase();
        $value = $base->getValue();
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    public function testGetRandomBoolReturnsBool(): void
    {
        $base = $this->makeBase();
        $this->assertIsBool($base->getRandomBool());
    }

    public function testStripPartOfArrayValue(): void
    {
        $base = $this->makeBase();
        $result = $base->stripPartOfArrayValue('.php', ['Foo.php', 'Bar.php', 'Baz.php']);
        $this->assertSame(['Foo', 'Bar', 'Baz'], $result);
    }

    public function testStripPartOfArrayValueNoMatch(): void
    {
        $base = $this->makeBase();
        $result = $base->stripPartOfArrayValue('.php', ['Foo', 'Bar']);
        $this->assertSame(['Foo', 'Bar'], $result);
    }
}
