<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Storage;

use App\Http\Requests\MinutesRequest;

class MinutesController extends Controller
{
    public function upload(MinutesRequest $minutesRequestrequest)
    {
        $validated = $minutesRequestrequest->validated();

        $image = $validated->file('image');
        $path = $image->store('images', 'public'); // Menyimpan gambar di storage/public/images

        return response()->json(['url' => asset('storage/' . $path)], 200);
    } 

    
}
