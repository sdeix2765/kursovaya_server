<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
       return DB::table('users')->get();
    }
    public function room_classes()
    {
       return DB::table('room_class')->get();
    }
    public function reviews()
    {
       return DB::table('reviews')->get();
    }
    
    public function rooms()
    {
       return DB::table('rooms')->get();
    }
    public function addreview(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',  
            'message' => 'required|max:500'
        ]);
        DB::table('reviews')->insert([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'message' => $validatedData['message'],
        ]);
    
        return response()->json(['message' => 'Добавлен новый отзыв']);
    }
    public function addguest(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',  
            'patronymic' => 'max:30',
            'number' => 'required|min:11|max:11',
            'email'=>'required|max:50'
        ]);
        $id =DB::table('guests')->insertGetId([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'patronymic' => $validatedData['patronymic'],
            'number' => $validatedData['number'],
            'email' => $validatedData['email'],
        ]);
    
        return response()->json(['message' => 'Добавлено', 'guest_id'=>$id]);
    }
    
    public function addbook(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required',
            'guest_id' => 'required',  
            'guest_count' => 'required',
            'time_from' => 'required',
            'time_to'=>'required'
        ]);
        DB::table('bookings')->insert([
            'room_id' => $validatedData['room_id'],
            'guest_id' => $validatedData['guest_id'],
            'guest_count' => $validatedData['guest_count'],
            'time_from' => $validatedData['time_from'],
            'time_to' => $validatedData['time_to'],
        ]);
    
        return response()->json(['message' => 'Добавлено']);
    }
}
