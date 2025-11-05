<?php

namespace App\Traits\Response;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    protected function messageResponse(string $message, int $statusCode = 200, ?array $data = null): JsonResponse
    {
        $responseData = ['message' => $message];

        if ($data !== null) {
            $responseData += $data;
        }

        return response()->json($responseData, $statusCode);
    }

    protected function errorResponse(?string $message = null, int $statusCode = 500, ?array $data = null): JsonResponse
    {
        $errorMessage = $message ?: 'Ошибка со стороны сервера!';
        $responseData = ['error' => $errorMessage];

        if ($data !== null) {
            $responseData += $data;
        }

        return response()->json($responseData, $statusCode);
    }


    protected function successResponse(string $message, int $statusCode = 200, ?array $data = null): JsonResponse
    {
        return $this->messageResponse($message, $statusCode, $data);
    }
    protected function notFoundResponse(string $title): JsonResponse
    {
        return $this->errorResponse("$title не найдено", 404);
    }


    protected function successCreateResponse(string $title, ?array $data = null): JsonResponse
    {
        return $this->successResponse("$title успешно создана!", 201, $data);
    }
    protected function errorCreateResponse(string $title, ?array $data = null): JsonResponse
    {
        return $this->errorResponse("$title не было создана!", 400, $data);
    }


    protected function successUpdateResponse(string $title, ?array $data = null): JsonResponse
    {
        return $this->successResponse("$title успешно обновлен!", 200, $data);
    }

    protected function errorUpdateResponse(string $title, ?array $data = null): JsonResponse
    {
        return $this->errorResponse("$title не было обновлено!", 400, $data);
    }


    protected function successDeleteResponse(string $title, ?array $data = null): JsonResponse
    {
        return $this->successResponse("$title успешно удалена!", 200, $data);
    }
    protected function errorDeleteResponse(string $title, ?array $data = null): JsonResponse
    {
        return $this->errorResponse("$title не было удалена!", 400, $data);
    }


    protected function successRestoreResponse(string $title, ?array $data = null): JsonResponse
    {
        return $this->successResponse("$title успешно восстановлена!", 200, $data);
    }
    protected function errorRestoreResponse(string $title, ?array $data = null): JsonResponse
    {
        return $this->errorResponse("$title не было восстановлена!", 400, $data);
    }
}
