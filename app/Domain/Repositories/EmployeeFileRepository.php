<?php

namespace App\Domain\Repositories;

interface EmployeeFileRepository
{
    public function saveFile($file):string;
}
