<?php

namespace Spatie\LivewireComments\Tests\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Comments\Models\Concerns\HasComments;

class Post extends Model
{
    use HasComments;
    use HasFactory;

    protected $guarded = [];

    public function commentableName(): string
    {
        return $this->name ?? '';
    }

    public function commentUrl(): string
    {
        return url('some-url');
    }
}
