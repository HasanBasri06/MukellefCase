<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait HttpResponseTrait {
    public function success(array|Collection|Model|null $data, string $message, int $code = 200) {
        return response()->json([
            'message' => $message,
            'code' => $code,
            'data' => !is_null($data) ? $data : []
        ], $code);
    }

    public function error(array|Collection|Model|null $data, string $message, int $code = 200) {
        return response()->json([
            'message' => $message,
            'code' => $code,
            'data' => !is_null($data) ? $data : []
        ], $code);
    }
}
