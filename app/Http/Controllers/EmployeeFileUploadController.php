<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFileUpload\EmployeeFileUploadStore;
use App\Services\Facades\EmployeeFileUploadFacade;
use Illuminate\Http\JsonResponse;

class EmployeeFileUploadController extends Controller
{
    //
    public function store(EmployeeFileUploadStore $request): JsonResponse
    {
        $file = $request->validated('file');
        $filepath = EmployeeFileUploadFacade::save(file_get_contents($file));
        EmployeeFileUploadFacade::processFileAsync($filepath, $request->user());

        return response()->json(['message' => 'Upload de visitantes realizado com sucesso!'], 201);
    }
}
