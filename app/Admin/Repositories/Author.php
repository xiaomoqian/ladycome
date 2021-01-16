<?php

namespace App\Admin\Repositories;

use App\Models\Author as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Author extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
