<?php
/**
 * Created by PhpStorm.
 * User: wei gao
 * Email:1225039937@qq.com
 * Date: 2019-08-14
 * Time: 9:58
 */

namespace App\Support;


use Illuminate\Http\Request;

interface ExportHelperInterface
{
    public function getExportHeaders(): array;

    public function getExportData(Request $request): \Generator;
}