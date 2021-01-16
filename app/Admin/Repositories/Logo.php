<?php

namespace App\Admin\Repositories;

use App\Models\Logo as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Logo extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
