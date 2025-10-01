<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel API",
 *     description="API de CRUD de usuários com Laravel",
 *     @OA\Contact(
 *         email="youremail@example.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor Local"
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"name","email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Teste"),
 *     @OA\Property(property="email", type="string", example="teste@teste.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-01T20:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-01T20:00:00Z")
 * )
 */
class SwaggerDefinitions {}