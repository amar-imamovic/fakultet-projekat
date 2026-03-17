<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        $sampleComments = [
            "Great post! Thanks for sharing this information.",
            "I've been looking for something like this. Very helpful!",
            "This is exactly what I needed to know. Appreciate it!",
            "Interesting perspective. I hadn't thought about it that way before.",
            "Could you elaborate more on this topic? I'd love to learn more.",
            "Thanks for the detailed explanation!",
            "This helped me solve a problem I was having. Much appreciated!",
            "I agree with your points. Well said!",
            "Do you have any resources for learning more about this?",
            "This is a game changer! Thanks for sharing.",
            "I've shared this with my team. Very useful!",
            "What would you recommend for beginners?",
            "This is gold! Saving this for later reference.",
            "Thanks for taking the time to write this up!",
            "I have a question about implementation details...",
        ];

        foreach ($posts as $post) {
            // Add 2-8 comments per post
            $commentCount = rand(2, 8);

            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'body' => $sampleComments[array_rand($sampleComments)],
                    'created_at' => $post->created_at->addHours(rand(1, 48)),
                ]);
            }
        }

        // Create some additional random comments
        Comment::factory(20)->create();
    }
}
