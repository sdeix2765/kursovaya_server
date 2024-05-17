<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiAdminController extends Controller
{
    public function addroom_class(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:room_class,name',
            'price' => 'required',
            'max_people' => 'required',
            'description' => 'required|min:50|max:500'
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = $validatedData['name'];
            $fileName .= $file->getClientOriginalName();
            $file->move(public_path('uploads/room_class'), $fileName);

        } else {
            return response()->json("Не удалось загрузить изображение",400);
        }

        DB::table('room_class')->insert([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'max_people' => $validatedData['max_people'],
            'description' => $validatedData['description'],
            'img' => $fileName,
        ]);
    
        return response()->json(['message' => 'Добавлен новый класс']);
    }
}   
