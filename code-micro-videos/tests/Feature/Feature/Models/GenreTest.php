<?php

namespace Tests\Feature\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use \Ramsey\Uuid\Uuid as RamseyUuid;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        $genre = Genre::create([
            'name' => 'test1'
        ]);
        $genres = Genre::all();
        $this->assertCount(1, $genres);
        $genreKey = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $genreKey
        );
    }

     public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test1'
        ]);
        $genre->refresh();

        $this->assertTrue(RamseyUuid::isValid($genre->id));
        $this->assertEquals('test1', $genre->name);
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1'
        ]);
        $genre->refresh();
        $genre->id = '0';

        $this->assertFalse(RamseyUuid::isValid($genre->id));
        $this->assertEquals('test1', $genre->name);
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => false
        ]);

        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'test1',
            'is_active' => true
        ]);

        $this->assertTrue($genre->is_active);
    }


    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'test_name',
            'is_active' => false
        ])->first();

        $data = [
            'name' => 'test_name_updated',
            'is_active' => true
        ];

        $genre->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'test_name',
            'is_active' => true
        ])->first();

        $this->assertTrue(RamseyUuid::isValid($genre->id));
        $this->assertEquals('test_name', $genre->name);
        $this->assertTrue($genre->is_active);

        $id = $genre->id;

        $genre->delete($genre);

        $genreNotFound = Genre::find($id);
        $this->assertNull($genreNotFound);
    }
}
