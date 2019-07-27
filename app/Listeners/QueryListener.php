<?php

namespace App\Listeners;


use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

class QueryListener
{
    public function handle(QueryExecuted $executed)
    {
        if (config('app.debug')) {
            $sql = str_replace("?", "'%s'", $executed->sql);
            foreach ($executed->bindings as $key => $binding) {
                if ($binding instanceof \DateTimeInterface) {
                    $executed->bindings[$key] = $binding->format('Y-m-d H:i:s');
                }
            }
            $log = vsprintf($sql, $executed->bindings) . " [query time: $executed->time ms]";

            Log::info($log);
        }
    }
}
