<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class BookController extends Controller
{

    #[OA\Get(
        path: '/api/books',
        tags: ['Books'],
        summary: 'Ambil semua data buku',
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
        $books = Book::all();
        return response()->json([
            'status' => 'success',
            'data' => $books,
            'message' => 'Data berhasil diambil'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $validated = $request->validate(
            [
                'judul' => 'required',
                'penulis' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required',
                'status' => 'required',
                'category_id'=>'required'
            ]
        );

        $book = Book::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
            'data' => $book

        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $book = Book::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $book,
            'message' => 'Data berhasil diambil'
        ],200);

    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $book = Book::find($id);
        $book->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $book,
            'message' => 'Data berhasil diupdate'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $book = Book::find($id);
        $book->delete();
        return response()->json([
            'status' => 'success',
            'data' => $book,
            'message' => 'Data berhasil dihapus'
        ],200);
    }
}
