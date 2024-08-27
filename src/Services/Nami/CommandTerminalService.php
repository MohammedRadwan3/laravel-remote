<?php

namespace src\Services\Nami;

use App\Services\MainService;
use src\Models\Nami\Command;

class CommandTerminalService extends MainService
{
    public function __construct(Command $model)
    {
        $this->model = $model;
    }
}
