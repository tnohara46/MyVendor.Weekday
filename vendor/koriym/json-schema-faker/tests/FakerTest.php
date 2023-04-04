<?php

declare(strict_types=1);

namespace JSONSchemaFaker\Test;

use JsonSchema\Validator;
use JSONSchemaFaker\Faker;
use JSONSchemaFaker\UnsupportedTypeException;

class FakerTest extends TestCase
{
    /**
     * @dataProvider getTypes
     */
    public function testFakeMustReturnValidValue($type)
    {
        $schema = $this->getFixture($type);
        $validator = new Validator();

        $actual = (new Faker)->generate($schema);
        $validator->check($actual, $schema);

        $this->assertTrue($validator->isValid(), (string) json_encode($validator->getErrors(), JSON_PRETTY_PRINT));
    }

    /**
     * @dataProvider getTypesAndFile
     */
    public function testFakeFromFile($type)
    {
        $schema = $this->getFile($type);
        $validator = new Validator();

        $actual = (new Faker)->generate(new \SplFileInfo($schema));
        $validator->check($actual, $schema);

        $this->assertTrue($validator->isValid(), (string) json_encode($validator->getErrors(), JSON_PRETTY_PRINT));
    }

    public function testGenerateInvalidParameter()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new Faker)->generate(null);
    }

    public function getTypes()
    {
        return [
            ['boolean'],
            ['null'],
            ['integer'],
            ['number'],
            ['string'],
            ['array'],
            ['object'],
            ['combining'],
            ['ref_inline']
        ];
    }

    public function getTypesAndFile()
    {
        return [
            ['boolean'],
            ['null'],
            ['integer'],
            ['number'],
            ['string'],
            ['array'],
            ['object'],
            ['combining'],
            ['ref_file'],
            ['ref_file_ref'],
            ['ref_file_double'],
            ['ref_array']
        ];
    }

    public function testFakeMustThrowExceptionIfInvalidType()
    {
        $this->expectException(UnsupportedTypeException::class);

        (new Faker)->generate((object) ['type' => 'xxxxx']);
    }
}
