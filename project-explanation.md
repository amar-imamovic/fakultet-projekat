# Project Explanation - What Was Added

This document explains the logic and purpose of files added to the Laravel project, organized by concept. Use this as a reference to understand when and why to implement each pattern.

---

## Table of Contents
1. [Models & Relationships](#models--relationships)
2. [Migrations](#migrations)
3. [Controllers](#controllers)
4. [Form Requests (Validation)](#form-requests-validation)
5. [Policies (Authorization)](#policies-authorization)
6. [Views & Blade](#views--blade)
7. [Factories & Seeders](#factories--seeders)

---

## Models & Relationships

### When to create a Model?
Create a model when you need to represent a database table as a PHP object. Models handle data retrieval, storage, and relationships.

**Files Added:**
- `app/Models/Post.php`
- `app/Models/Comment.php`
- `app/Models/Like.php`

### Key Concepts:

#### Relationships
Relationships define how models connect to each other. Laravel provides methods to make this easy:

```php
// User has many Posts (one-to-many)
public function posts() {
    return $this->hasMany(Post::class);
}

// Post belongs to User (inverse of hasMany)
public function user() {
    return $this->belongsTo(User::class);
}

// Post has many Comments
public function comments() {
    return $this->hasMany(Comment::class);
}
```

**When to use which:**
- `hasOne` / `belongsTo` - One-to-one (e.g., User has one Profile)
- `hasMany` / `belongsTo` - One-to-many (e.g., User has many Posts, Post belongs to User)
- `belongsToMany` - Many-to-many (e.g., Post has many Tags, Tag has many Posts - needs pivot table)
- `hasManyThrough` - Access distant relations (e.g., Country has many Posts through Users)

#### Eager Loading (withCount, with)
```php
// Adds a 'comments_count' attribute without loading all comments
Post::withCount('comments')->get();

// Loads the actual related models to avoid N+1 queries
Post::with(['user', 'comments'])->get();
```

**When to use:**
- Use `withCount` when you only need the count (faster)
- Use `with` when you need to display the related data
- Always eager load to avoid N+1 query problems

---

## Migrations

### When to create a Migration?
Create a migration whenever you need to create or modify database tables. Migrations are version control for your database.

**Files Added:**
- `database/migrations/2026_03_16_163649_create_posts_table.php`
- `database/migrations/2026_03_16_163649_create_comments_table.php`
- `database/migrations/2026_03_16_163649_create_likes_table.php`

### Key Migration Patterns:

#### Foreign Keys
```php
$table->foreignId('user_id')->constrained()->onDelete('cascade');
```
- `constrained()` - Automatically references `users.id`
- `onDelete('cascade')` - When user is deleted, delete their posts too
- Alternative: `onDelete('set null')` - Keep posts but set user_id to null

#### Common Column Types
```php
$table->id();                    // Auto-increment primary key
$table->string('title');         // VARCHAR
$table->text('body');            // TEXT (longer than string)
$table->boolean('is_pinned')->default(false);
$table->timestamps();            // created_at + updated_at
$table->softDeletes();           // deleted_at (for soft deletes)
```

#### Unique Constraints
```php
// One like per user per post
$table->unique(['user_id', 'post_id']);
```

---

## Controllers

### When to create a Controller?
Create a controller to group related request handling logic. One controller per resource (Post, Comment, etc.) is standard.

**Files Added:**
- `app/Http/Controllers/PostController.php` (public actions)
- `app/Http/Controllers/CommentController.php`
- `app/Http/Controllers/LikeController.php`
- `app/Http/Controllers/Admin/PostController.php` (admin actions)
- `app/Http/Controllers/Admin/CommentController.php`
- `app/Http/Controllers/Moderator/PostController.php` (moderator actions)
- `app/Http/Controllers/Moderator/CommentController.php`

### Controller Structure Pattern

#### Resource Controller (full CRUD)
```php
class PostController extends Controller
{
    // GET /posts - List all
    public function index() { }

    // GET /posts/create - Show create form
    public function create() { }

    // POST /posts - Store new
    public function store(Request $request) { }

    // GET /posts/{id} - Show single
    public function show(Post $post) { }

    // GET /posts/{id}/edit - Show edit form
    public function edit(Post $post) { }

    // PUT /posts/{id} - Update
    public function update(Request $request, Post $post) { }

    // DELETE /posts/{id} - Delete
    public function destroy(Post $post) { }
}
```

#### Route Model Binding
```php
// Laravel automatically finds the Post by ID
public function show(Post $post) {
    // $post is already loaded, no need for Post::find($id)
    return view('posts.show', compact('post'));
}
```

#### Authorization in Controllers
```php
public function update(Request $request, Post $post) {
    // Check if user can update this post
    $this->authorize('update', $post);
    // or
    if (auth()->user()->cannot('update', $post)) {
        abort(403);
    }
}
```

### When to use separate controllers?
- **Single Responsibility**: Admin/Moderator/User have different permissions
- **Namespace Organization**: `Admin\PostController` vs `PostController`
- **Different Logic**: Admin can delete any post, User can only delete their own

---

## Form Requests (Validation)

### When to create a Form Request?
Create a Form Request when validation logic is complex or reused. It separates validation from controller logic.

**Files Added:**
- `app/Http/Requests/Post/StoreRequest.php`
- `app/Http/Requests/Post/UpdateRequest.php`
- `app/Http/Requests/Comment/StoreRequest.php`
- `app/Http/Requests/Admin/Post/UpdateRequest.php`
- `app/Http/Requests/Moderator/Post/UpdateRequest.php`

### Structure
```php
class StoreRequest extends FormRequest
{
    // Who can make this request?
    public function authorize(): bool {
        return true; // or auth()->check()
    }

    // Validation rules
    public function rules(): array {
        return [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_pinned' => 'boolean',
        ];
    }

    // Custom error messages (optional)
    public function messages(): array {
        return [
            'title.required' => 'Please provide a title.',
        ];
    }
}
```

### Usage in Controller
```php
public function store(StoreRequest $request) {
    // Validation already passed, data is safe
    $validated = $request->validated();
    Post::create($validated);
}
```

### When to use inline validation vs Form Request?
- **Inline** (`$request->validate([...])`): Simple, one-off validation
- **Form Request**: Complex rules, reused validation, authorization logic needed

---

## Policies (Authorization)

### When to create a Policy?
Create a policy to centralize authorization logic for a model. Policies answer "Can this user do X to this resource?"

**Files Added:**
- `app/Policies/PostPolicy.php`
- `app/Policies/CommentPolicy.php`

### Policy Structure
```php
class PostPolicy
{
    // Can user view any post? (usually true for public)
    public function viewAny(User $user): bool {
        return true;
    }

    // Can user view this specific post?
    public function view(User $user, Post $post): bool {
        return true; // or $post->is_published
    }

    // Can user create posts?
    public function create(User $user): bool {
        return $user->role_id === Role::USER;
    }

    // Can user update THIS post?
    public function update(User $user, Post $post): bool {
        return $user->id === $post->user_id || $user->isAdmin();
    }

    // Can user delete THIS post?
    public function delete(User $user, Post $post): bool {
        return $user->id === $post->user_id;
    }
}
```

### Using Policies

#### In Controllers
```php
$this->authorize('update', $post);  // Auto-uses PostPolicy
```

#### In Blade Views
```blade
@can('update', $post)
    <a href="{{ route('posts.edit', $post) }}">Edit</a>
@endcan

@cannot('delete', $post)
    <span>You cannot delete this</span>
@endcannot
```

#### In Routes
```php
Route::put('/posts/{post}', [PostController::class, 'update'])
    ->middleware('can:update,post');
```

### Policy vs Middleware
- **Middleware**: "Is user an admin?" (broad checks)
- **Policy**: "Can this user edit this specific post?" (resource-specific checks)

---

## Views & Blade

### When to create a View?
Create a view for every page/screen. Organize by resource and role.

**Files Added:**
- `resources/views/posts/*.blade.php` (public)
- `resources/views/admin/posts/*.blade.php`
- `resources/views/admin/comments/*.blade.php`
- `resources/views/moderator/posts/*.blade.php`
- `resources/views/moderator/comments/*.blade.php`

### Layout Inheritance Pattern

#### The Layout (`layouts.app`)
```blade
<!DOCTYPE html>
<html>
<head>@yield('title', config('app.name'))</head>
<body>
    @include('layouts.navigation')
    <main>
        @yield('content')
    </main>
</body>
</html>
```

#### Role Dashboards (extend app)
```blade
{{-- admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('nav-links')
    {{-- Admin-specific navigation --}}
@endsection

@section('content')
    <h2>Admin Dashboard</h2>
@endsection
```

#### Resource Views (extend role dashboard)
```blade
{{-- admin/posts/index.blade.php --}}
@extends('admin.dashboard')

@section('content')
    <h1>Manage Posts</h1>
    {{-- Content here --}}
@endsection
```

### Blade Directives

#### Conditionals
```blade
@if($condition)
@elseif($other)
@else
@endif

@unless($condition)  {{-- if not --}}
@endunless

@isset($variable)
@endisset

@empty($collection)
@endempty
```

#### Loops
```blade
@foreach($posts as $post)
    {{ $loop->iteration }} {{-- 1, 2, 3... --}}
    {{ $loop->first }} {{-- true on first iteration --}}
    {{ $loop->last }}
@empty
    <p>No posts found</p>
@endforeach

@forelse($posts as $post)
    {{-- has items --}}
@empty
    {{-- no items --}}
@endforelse
```

#### Authentication
```blade
@auth
    {{-- Logged in --}}
@endauth

@guest
    {{-- Not logged in --}}
@endguest
```

---

## Factories & Seeders

### When to create a Factory?
Create a factory to generate fake data for testing and development.

**Files Added:**
- `database/factories/PostFactory.php`
- `database/factories/CommentFactory.php`

### Factory Structure
```php
class PostFactory extends Factory
{
    public function definition(): array {
        return [
            'user_id' => User::factory(), // Create user automatically
            'title' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'is_pinned' => false,
        ];
    }

    // Custom states
    public function pinned(): static {
        return $this->state(fn (array $attributes) => [
            'is_pinned' => true,
        ]);
    }
}
```

### Usage
```php
// Create one
Post::factory()->create();

// Create many
Post::factory()->count(50)->create();

// With specific attributes
Post::factory()->create(['user_id' => 1]);

// Using state
Post::factory()->pinned()->create();
```

### When to create a Seeder?
Create a seeder to populate the database with initial/realistic data.

**Files Added:**
- `database/seeders/PostSeeder.php`
- `database/seeders/CommentSeeder.php`

### Seeder Structure
```php
class DatabaseSeeder extends Seeder
{
    public function run(): void {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => Role::ADMIN,
        ]);

        // Create posts with comments
        Post::factory(100)
            ->has(Comment::factory()->count(5))
            ->create();
    }
}
```

---

## Common Patterns Summary

| Task | Pattern | File Type |
|------|---------|-----------|
| New database table | Create migration + model | Migration, Model |
| Relate models | Define relationships | Model |
| CRUD operations | Resource controller | Controller |
| Form validation | Create Form Request | Request class |
| Permission checks | Create Policy | Policy |
| Display data | Create Blade view | View |
| Test data | Create Factory + Seeder | Factory, Seeder |

---

## Quick Reference: File Generation Commands

```bash
# Model + Migration + Factory + Seeder + Policy + Controller
php artisan make:model Post -mfsc --policy --resource

# Just the migration
php artisan make:migration create_posts_table

# Form Request
php artisan make:request Post/StoreRequest

# Policy for existing model
php artisan make:policy PostPolicy --model=Post

# Seeder
php artisan make:seeder PostSeeder

# Factory
php artisan make:factory PostFactory --model=Post
```
