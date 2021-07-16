<?php

namespace Jotapegue\Tars\Tests\Unit;

use Orchestra\Testbench\TestCase;
use Jotape\Tars\MappingAttributes;

class MappingAttributesTest extends TestCase
{
    protected $person;

    protected function setUp() : void
    {
        $this->person = $this->getMockBuilder(MappingAttributes::class);
    }

    /** @test */
    public function hasClassMappingAttributes()
    {
        $this->assertTrue(class_exists(MappingAttributes::class));
    }

    /** @test */
    public function MappingAttributeClassTransformsArrayIntoItsOwnAttributes()
    {
        $person = [
            'name' => 'João Pedro',
            'age' => '32'
        ];

        $mapping = new class($person) extends MappingAttributes {};

        $this->assertEquals('João Pedro', $mapping->name);
        $this->assertEquals('32', $mapping->age);
    }

    /** @test */
    public function MappingAttributeClassTransformsObjectIntoItsOwnAttributes()
    {
        $person = (object) [
            'name' => 'João Pedro',
            'age' => '32'
        ];

        $mapping = new class($person) extends MappingAttributes {};

        $this->assertEquals('João Pedro', $mapping->name);
        $this->assertEquals('32', $mapping->age);
    }

    /** @test */
    public function MappingAttributeClassTranslateAttributesFromArray()
    {
        $person = [
            'name' => 'João Pedro',
            'age' => '32'
        ];

        $mapping = new class($person) extends MappingAttributes {
            protected $mapping = [
                'nome' => 'name',
                'idade' => 'age',
            ];
        };

        $this->assertEquals('João Pedro', $mapping->nome);
        $this->assertEquals('32', $mapping->idade);
    }

    /** @test */
    public function MappingAttributeClassTranslateAttributesFromObject()
    {
        $person = (object) [
            'name' => 'João Pedro',
            'age' => '32'
        ];

        $mapping = new class($person) extends MappingAttributes {
            protected $mapping = [
                'nome' => 'name',
                'idade' => 'age',
            ];
        };

        $this->assertEquals('João Pedro', $mapping->nome);
        $this->assertEquals('32', $mapping->idade);
    }

    /** @test */
    public function MappingAttributeClassConvertToArray()
    {
        $person = (object) [
            'name' => 'João Pedro',
            'age' => '32'
        ];

        $person_expected = [
            'nome' => 'João Pedro',
            'idade' => '32'
        ];

        $mapping = new class($person) extends MappingAttributes {
            protected $mapping = [
                'nome' => 'name',
                'idade' => 'age',
            ];
        };

        $this->assertEquals($person_expected, $mapping->toArray());
    }

    /** @test */
    public function MappingAttributeClassAddingCasting()
    {
        $person = (object) [
            'date' => '2020-31-12',
        ];

        $mapping = new class($person) extends MappingAttributes {
            
            protected $mapping = [
                'data' => 'date',
            ];

            public function getDataAttribute()
            {
                $this->data = date('d/m/Y', strtotime($this->date));
            }
        };

        $this->assertEquals('31/12/2020', $mapping->data);
    }
}