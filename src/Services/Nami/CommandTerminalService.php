<?php

namespace src\Services\Nami;

use src\Models\Nami\Command;
use App\Services\MainService;

class CommandTerminalService extends MainService
{
    public function __construct(Command $model)
    {
        $this->model = $model;
    }
}
