<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->name();
        $slug = Str::slug($title);
        $month = random_int(1, 12) * -1;
        strtotime("$month month");
        return [
            "code" => random_int(1000, 9999),
            "title" => $title,
            "subtitle" => $this->faker->text(),
            "description" => $this->faker->text(),
            "price_mp" => $mp = random_int(200, 9999),
            "price_sp" => $mp - random_int(100, 200),
            "slug" => $slug,
            "image_url" => "https://placehold.co/1200x1600?text=$title",
            "category_id" => 1,
            "is_returnable" => random_int(0, 1),
            "is_published" => random_int(0, 1),
            "published_at" => date("Y-m-d H:i:s", strtotime("$month month")),
        ];
    }
}
