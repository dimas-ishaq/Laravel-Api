<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;



class AuthController extends Controller
{
    #[OA\Get(
        path: '/api/users',
        tags: ['Users'],
        summary: 'Ambil semua data user',
        responses: [
            new OA\Response(response: 200, description: 'Success'),
            new OA\Response(response: 401, description: 'Unauthorized')
        ]
    )]

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'data' => $users,
            'message' => 'Data berhasil diambil'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */


    #[OA\Post(
        path: '/api/register',
        summary: 'Buat user baru',
        description: 'Endpoint ini digunakan untuk meregistrasi user baru ke dalam sistem.',
        tags: ['Users'],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name', 'email', 'password'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Dimas Maulana Ishaq'),
                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'dimasmaulanaishaq@example.com'),
                new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Akun berhasil dibuat',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 1),
                new OA\Property(property: 'name', type: 'string', example: 'Dimas Maulana Ishaq'),
                new OA\Property(property: 'email', type: 'string', example: 'dimasmaulanaishaq@example.com'),
                new OA\Property(property: 'created_at', type: 'string', example: '2026-02-04T07:10:54.000000Z'),
                new OA\Property(property: 'updated_at', type: 'string', example: '2026-02-04T07:10:54.000000Z'),
            ]
        )
    )]

    #[OA\Response(response: 422, description: 'Email sudah terdaftar', content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'message', type: 'string', example: 'The email has already been taken.'),
            new OA\Property(property: 'errors', type: 'object', additionalProperties: true, example: ['email' => ['The email has already been taken.']])
        ]
    ))]
    public function create(Request $request)
    {
        //membuat user
        $validation = $request->validate(array(
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ));

        // 
        $hashed_password = Hash::make($validation['password']);


        $newUser = User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => $hashed_password,

        ]);

        return response()->json($newUser, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
