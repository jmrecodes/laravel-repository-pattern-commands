<?php

namespace App;

use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

interface TestRepositoryInterface
{
    public function create(array $data): Test;

    public function all(): Collection;

    public function find(int $id): ?Test;
}