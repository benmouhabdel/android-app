<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'post_id' => Post::factory(),  // Assurez-vous que Post est correctement importé
            'author' => $this->faker->name,
            'content' => $this->faker->paragraph,
        ];
    }
}
