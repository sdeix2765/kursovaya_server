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
            'description' => 'required|max:500'
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
    public function addroom(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:rooms,name',
            'class_id' => 'required',  
            'description' => 'required|max:500'
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = $validatedData['name'];
            $fileName .= $file->getClientOriginalName();
            $file->move(public_path('uploads/room'), $fileName);

        } else {
            return response()->json("Не удалось загрузить изображение",400);
        }

        DB::table('rooms')->insert([
            'name' => $validatedData['name'],
            'class_id' => $validatedData['class_id'],
            'description' => $validatedData['description'],
            'img' => $fileName,
        ]);
    
        return response()->json(['message' => 'Добавлен новый номер']);
    }
}   
