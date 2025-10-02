<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Lista todos os usuários",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json($this->service->getAllUsers());
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Retorna um usuário pelo ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */
    public function show($id)
    {
        $user = $this->service->getUser($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        return response()->json($user);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Cria um novo usuário",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="Teste"),
     *             @OA\Property(property="email", type="string", example="teste@teste.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=400, description="Dados inválidos ou email já existe")
     * )
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ];

        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'min' => 'A :attribute deve ter pelo menos :min caracteres.',

            'email.unique' => 'Este e-mail já está em uso.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ];

        $data = $request->validate($rules, $messages);
        $data['password'] = bcrypt($data['password']);

        $user = $this->service->createUser($data);
        return response()->json($user, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Atualiza um usuário pelo ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Teste Atualizado"),
     *             @OA\Property(property="email", type="string", example="teste2@teste.com"),
     *             @OA\Property(property="password", type="string", example="654321")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=404, description="Usuário não encontrado"),
     *     @OA\Response(response=400, description="Dados inválidos")
     * )
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $id, 
            'password' => 'sometimes|string|min:6',
        ];

        $messages = [
            'required' => 'O campo :attribute é obrigatório.', 
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'min' => 'A :attribute deve ter pelo menos :min caracteres.',
            'email.unique' => 'Este e-mail já está em uso por outro usuário.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ];

        $data = $request->validate($rules, $messages);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = $this->service->updateUser($id, $data);
        
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Remove um usuário pelo ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Usuário removido"),
     *     @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */
    public function destroy($id)
    {
        $user = $this->service->deleteUser($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        return response()->json(null, 204);
    }
}