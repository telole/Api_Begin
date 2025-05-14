<?php

namespace App\Http\Controllers;

use App\Models\artikels;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'message' => 'list artikel',
            'artikel' => artikels::latest('publish_date')->get(),
        ]);

        //untuk menampilkan data terbaru sebanyak 3 data dalam satu pemanggilan
        // $artikel = artikels::latest('publish_date');

        // //validasi jika data kosong
        // if($artikel->isEmpty()) {
        //     return response()->json([
        //         'message' => 'empty',
        //         'status' => 404
        //     ], 404); 
        // }else {
        //     return response()->json([
        //         'message' => 'success',
        //         'status' => Response::HTTP_OK,
        //         'data' => [
        //             $artikel
        //         ]
        //     ]);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //variabel untuk membuat validator sebeluum membuat execute 
        $validators = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        //validasi jika validator gagal
        if ($validators->fails()) {
            return response()->json([
                    'error' => $validators->errors(),
            ]);
        }


        //penggunaan "validate()" untuk melempar exception jika gagal dijalankan
        $validator = $validators->validate();

        //untuk mengirim data ke database menggunaan $validator 
        $artikel = artikels::create([
            'title' => $validator['title'],
            'content' => $validator['content'],
            'publish_date' => now()
        ]);

        //validasi dan pengecekankalau data berhasil di execute
        return response()->json([
            'message' => 'data created Successfull',
            'data' => $artikel
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        //mencari data artikel dengan parameter $id
        //"note: dalam laravel penggunaan $id dalam parameter berfungsi sebagai pemanggilan primary key pada table yang sering kita acukan apada table id"
        $artikel = artikels::find($id);

        //validasi jika data kosong
        if(!$artikel) {
            return response()->json([
            'message' => 'Data Not Found'
            ], 404);
        }

        // menampilkan respon jika data ada dan berhasil
        return response()->json([
            'message' => 'data get success',
            'data' => $artikel
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $artikel = artikels::find($id);

        if(!$artikel) {
            return response()->json([
                'message' => 'notfound'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            // 'pubish_date' => 'nullable'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ]);
        }

        $artikel->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            // 'publish_date' => $request->input('publish_date')
        ]);

        return response()->json([
            'message' => 'data updated',
            'data' => $artikel
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $artikel = artikels::find($id);

        if(!$artikel) {
            return response()->json([
                'message' => 'notfound'
            ]);
        }

        $artikel->delete();

        return response()->json([
            'message' => 'dihapus'
        ]);
    }

    public function search(Request $request)
    {
        

        $query = Artikels::latest('publish_date');
        $key = $request->input('title');

            if ($key) {
             $query->where('title', 'like', "%{$key}%");
             }

             $artikel = $query->paginate(2);

             if ($artikel->isEmpty()) {
              return response()->json([
            'message' => 'empty',
            'status' => 404
             ], 404);
             }

             return response()->json([
                'message' => 'success',
                'status' => Response::HTTP_OK,
                 'data' => $artikel
             ]);
        }
}
