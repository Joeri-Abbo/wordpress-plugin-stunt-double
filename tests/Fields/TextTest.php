<?php

namespace StuntDouble\Tests\Fields;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use StuntDouble\Fields\Text;

class TextTest extends TestCase
{
    private function makeText(string $fieldName): Text
    {
        $faker = Factory::create();
        return new Text(['name' => $fieldName], $faker, 1);
    }

    public function testGetValueReturnsString(): void
    {
        $text = $this->makeText('some_generic_field');
        $this->assertIsString($text->getValue());
    }

    public function testGetValueForCompanyName(): void
    {
        $text = $this->makeText('company_name');
        $value = $text->getValue();
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    public function testGetValueForFirstName(): void
    {
        $text = $this->makeText('first_name');
        $value = $text->getValue();
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    public function testGetValueForLastName(): void
    {
        $text = $this->makeText('last_name');
        $value = $text->getValue();
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    public function testGetValueForJobTitle(): void
    {
        $text = $this->makeText('job_title');
        $value = $text->getValue();
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    public function testGetValueForCompany(): void
    {
        $text = $this->makeText('company');
        $value = $text->getValue();
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }
}
