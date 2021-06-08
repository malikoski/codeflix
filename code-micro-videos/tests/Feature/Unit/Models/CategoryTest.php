<?php

namespace Tests\Feature\Unit\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;
use App\Models\Traits\Uuid;

class CategoryTest extends TestCase
{

    private $category;


    public function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }


    public function testFillable()
    {
        $fillable = ['name', 'description', 'is_active'];
        $this->assertEquals($fillable, $this->category->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
        print_r($categoryTraits);
        print_r($traits);
    }

    public function testCasts()
    {
        $casts = ['id' => 'string', 'is_active' => 'boolean'];
        $this->assertEquals($casts, $this->category->getCasts());
    }

    public function testIncrementing()
    {
        $this->assertFalse($this->category->incrementing);
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        foreach ($dates as $date) {
            $this->assertContains($date, $this->category->getDates());
        }
        $this->assertCount(count($dates), $this->category->getDates());
    }
}
