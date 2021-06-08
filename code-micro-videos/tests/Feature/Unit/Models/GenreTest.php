<?php

namespace Tests\Feature\Unit\Models;

use App\Models\Genre;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;
use \App\Models\Traits\Uuid;

class GenreTest extends TestCase
{
    private $genre;

    public function setUp() : void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testFillable()
    {
        $fillable = ['name',  'is_active'];
        $this->assertEquals($fillable, $this->genre->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $genreTraits = array_keys(class_uses(Genre::class));
        $this->assertEquals($traits, $genreTraits);
        print_r($genreTraits);
        print_r($traits);
    }

    public function testCasts()
    {
        $casts = ['id' => 'string', 'is_active' => 'boolean'];
        $this->assertEquals($casts, $this->genre->getCasts());
    }

    public function testIncrementing()
    {
        $this->assertFalse($this->genre->incrementing);
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        foreach ($dates as $date) {
            $this->assertContains($date, $this->genre->getDates());
        }
        $this->assertCount(count($dates), $this->genre->getDates());
    }

}
