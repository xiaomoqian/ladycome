<?php

namespace App\Admin\Repositories;

use App\Models\Relay as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Relay extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
