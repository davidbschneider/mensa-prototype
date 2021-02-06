<?php

namespace Database\Factories;

use App\Models\Admin;

class AdminFactory extends UserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;
}
