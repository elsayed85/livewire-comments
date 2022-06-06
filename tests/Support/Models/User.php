<?php

namespace DanPalmieri\LivewireComments\Tests\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as BaseUser;
use Spatie\Comments\Models\Concerns\InteractsWithComments;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;

class User extends BaseUser implements CanComment
{
    use HasFactory;
    use InteractsWithComments;
}
