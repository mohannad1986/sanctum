<?php

namespace App\Traits;

trait HttpResponses {
    // الداتا الي ح نرجعها
    // الرسالة الها قيمة افتراضية نل
    // رقم الكود الافتراضي 200
    protected function success($data, string $message = null, int $code = 200)
    {
        // جيسون ميثود بحول الاري العادية الي جسون
        return response()->json([
            'status' => 'Request was successful.',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    // تابع الخطا
    // لن نرسل كود افتراضي بل سنضعه في كل حالة
    protected function error($data, string $message = null, int $code)
    {
        return response()->json([
            'status' => 'An error has occurred...',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
