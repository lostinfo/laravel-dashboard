<?php

namespace App\Support;


use Illuminate\Http\Request;

interface ExportHelperInterface
{
    public function getExportHeaders(): array;

    public function getExportData(Request $request): \Generator;
}
