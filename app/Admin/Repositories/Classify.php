<?php

namespace App\Admin\Repositories;

use App\Models\Classify as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Classify extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
