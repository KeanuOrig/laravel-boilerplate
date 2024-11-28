<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use \Illuminate\Http\UploadedFile;
use \Illuminate\Http\File;

trait RunInTransaction
{   
    protected function executeFunction(callable $function)
        {
            $daily_log = app('Psr\Log\LoggerInterface')->channel(env('LOG_CHANNEL', 'googlecloud'));

            DB::beginTransaction();

            try {
                $data = call_user_func($function);
                DB::commit();

                return response()->json(array(
                    "code" => 200,
                    "message" => "Good",
                    "result" => $data
                ), 200);

            } catch (\Exception $e) {
                DB::rollback();
                
                return response()->json(array(
                    "code" => 500,
                    "message" => "Failed",
                    "error" => $e->getMessage()
                ), 500);
            }
        }
}