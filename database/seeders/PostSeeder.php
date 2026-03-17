<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Sample posts with realistic content
        $posts = [
            [
                'title' => 'Welcome to our new Forum!',
                'body' => "Hello everyone!\n\nWe're excited to launch our new community forum. This is a place where you can:\n\n- Share your ideas and thoughts\n- Ask questions and get help\n- Connect with other members\n- Stay updated on the latest news\n\nPlease be respectful and follow our community guidelines. Let's build something great together!\n\nHappy posting!",
                'is_pinned' => true,
                'is_locked' => false,
            ],
            [
                'title' => 'Community Guidelines - Please Read',
                'body' => "Welcome to our community! To ensure everyone has a positive experience, please follow these guidelines:\n\n1. Be respectful and kind to others\n2. No spam or self-promotion\n3. Stay on topic in discussions\n4. Use appropriate language\n5. Help others when you can\n\nViolations may result in warnings or account suspension.\n\nThank you for being part of our community!",
                'is_pinned' => true,
                'is_locked' => true,
            ],
            [
                'title' => 'Best practices for Laravel development',
                'body' => "I've been working with Laravel for a few years now and wanted to share some best practices:\n\n1. Use Eloquent ORM effectively - leverage relationships and eager loading\n2. Follow PSR standards for code consistency\n3. Use form requests for validation\n4. Implement proper error handling\n5. Write tests for critical functionality\n6. Use migrations for database changes\n7. Keep controllers thin, models rich\n\nWhat are your favorite Laravel tips? Share in the comments!",
                'is_pinned' => false,
                'is_locked' => false,
            ],
            [
                'title' => 'Introduction to Tailwind CSS',
                'body' => "Tailwind CSS has changed the way I style web applications. Here are some reasons why I love it:\n\n- Utility-first approach speeds up development\n- Highly customizable with configuration\n- Responsive design made easy\n- Consistent spacing and color scales\n- Great documentation\n\nIf you haven't tried it yet, I highly recommend giving it a shot. The learning curve is worth it!\n\nHas anyone else made the switch to Tailwind? What has your experience been like?",
                'is_pinned' => false,
                'is_locked' => false,
            ],
            [
                'title' => 'Looking for project collaborators',
                'body' => "Hi everyone!\n\nI'm working on an open-source project and looking for collaborators. The project is a task management application built with Laravel and Vue.js.\n\nWhat I'm looking for:\n- Frontend developers (Vue.js/Tailwind)\n- Backend developers (Laravel/PHP)\n- UI/UX designers\n\nIf you're interested in contributing or want to learn more, drop a comment below or send me a message!\n\nThanks!",
                'is_pinned' => false,
                'is_locked' => false,
            ],
            [
                'title' => 'Weekly Discussion: What are you working on?',
                'body' => "It's that time of the week again!\n\nShare what you've been working on lately. It could be:\n- A personal project\n- Something you learned\n- A challenge you're facing\n- A tool you discovered\n\nLet's support each other and maybe find some inspiration!\n\nI'll start: I've been learning about Laravel's queue system and implementing background jobs for email notifications. It's been a game changer for performance!",
                'is_pinned' => false,
                'is_locked' => false,
            ],
            [
                'title' => 'Database optimization tips',
                'body' => "After optimizing several Laravel applications, here are my top database tips:\n\n1. Add indexes to frequently queried columns\n2. Use eager loading to avoid N+1 queries\n3. Cache frequently accessed data\n4. Use database transactions for multiple operations\n5. Optimize your queries with EXPLAIN\n6. Consider using Redis for session/cache storage\n\nThese changes can dramatically improve your application performance.\n\nWhat optimization techniques have worked for you?",
                'is_pinned' => false,
                'is_locked' => false,
            ],
            [
                'title' => 'Security best practices for web applications',
                'body' => "Security should always be a priority. Here are essential practices:\n\n1. Never trust user input - validate everything\n2. Use prepared statements/parameterized queries\n3. Implement proper authentication and authorization\n4. Keep dependencies updated\n5. Use HTTPS everywhere\n6. Store passwords securely (bcrypt/Argon2)\n7. Protect against CSRF attacks\n8. Implement rate limiting\n\nStay safe out there! Any other security tips to share?",
                'is_pinned' => false,
                'is_locked' => false,
            ],
        ];

        foreach ($posts as $index => $postData) {
            Post::create([
                'user_id' => $users->random()->id,
                'title' => $postData['title'],
                'body' => $postData['body'],
                'is_pinned' => $postData['is_pinned'],
                'is_locked' => $postData['is_locked'],
                'created_at' => now()->subDays(8 - $index),
            ]);
        }

        // Create additional random posts
        Post::factory(12)->create();
    }
}
