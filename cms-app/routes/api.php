Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', App\Http\Controllers\Api\PostApiController::class);
});
