# Laravel Repository Pattern

A Laravel application implementing the Repository Pattern with custom Artisan commands for a clean, scalable, and maintainable architecture.

## Overview

This project provides a ready-to-use implementation of the Repository Pattern in Laravel. It's designed to help developers separate data access logic from business logic, leading to a more organized, testable, and scalable application. The included custom Artisan commands streamline the process of creating new repositories and services.

## Features

-   **Clean Architecture**: Promotes separation of concerns.
-   **Custom Artisan Commands**: `make:repository` and `make:service` for rapid development.
-   **Base Repository**: Includes common Eloquent methods to reduce boilerplate code.
-   **Scalable and Maintainable**: A solid foundation for projects of any size.

## Getting Started

### Installation

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/your-repository.git
    cd your-repository
    ```

2.  **Install dependencies:**

    ```bash
    composer install
    ```

3.  **Set up your environment:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

### Usage

The core of this implementation lies in its custom Artisan commands.

#### `make:repository {name}`

This command creates a new repository and its corresponding interface.

```bash
php artisan make:repository Post
```

This will generate:

-   `app/Interfaces/PostInterface.php`
-   `app/Repositories/PostRepository.php`

#### `make:service {name}`

This command creates a new service class.

```bash
php artisan make:service Post
```

This will generate:

-   `app/Services/PostService.php`

## The Repository Pattern in Action

Here’s a typical workflow for using the repository pattern in this application:

1.  **Create a Model and Migration:**

    ```bash
    php artisan make:model Post -m
    ```

2.  **Generate the Repository and Service:**

    ```bash
    php artisan make:repository Post
    php artisan make:service Post
    ```

3.  **Define the Interface (`app/Interfaces/PostInterface.php`):**

    ```php
    <?php

    namespace App\Interfaces;

    interface PostInterface
    {
        // Define your repository methods here
    }
    ```

4.  **Implement the Repository (`app/Repositories/PostRepository.php`):**

    The generated repository extends a `BaseRepository` that already includes `all`, `find`, `create`, `update`, and `delete` methods.

    ```php
    <?php

    namespace App\Repositories;

    use App\Interfaces\PostInterface;
    use App\Models\Post;

    class PostRepository extends BaseRepository implements PostInterface
    {
        protected $model;

        public function __construct(Post $model)
        {
            $this->model = $model;
        }

        // Implement your custom repository methods here
    }
    ```

5.  **Bind the Interface to the Repository:**

    In `app/Providers/AppServiceProvider.php`, bind the `PostInterface` to the `PostRepository`.

    ```php
    public function register()
    {
        $this->app->bind(
            \App\Interfaces\PostInterface::class,
            \App\Repositories\PostRepository::class
        );
    }
    ```

6.  **Use the Repository in your Service (`app/Services/PostService.php`):**

    ```php
    <?php

    namespace App\Services;

    use App\Interfaces\PostInterface;

    class PostService
    {
        protected $postRepository;

        public function __construct(PostInterface $postRepository)
        {
            $this->postRepository = $postRepository;
        }

        public function getAllPosts()
        {
            return $this->postRepository->all();
        }
    }
    ```

7.  **Inject the Service into your Controller:**

    ```php
    <?php

    namespace App\Http\Controllers;

    use App\Services\PostService;

    class PostController extends Controller
    {
        protected $postService;

        public function __construct(PostService $postService)
        {
            $this->postService = $postService;
        }

        public function index()
        {
            $posts = $this->postService->getAllPosts();
            return view('posts.index', compact('posts'));
        }
    }
    ```

## Contributing

Contributions are welcome! Please feel free to submit a pull request.

## License

This project is open-sourced software licensed under the [GPL-3.0 license](https://www.gnu.org/licenses/gpl-3.0.en.html).