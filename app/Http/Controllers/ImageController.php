<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'image' => 'required|image|max:5000'
        ]);

        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $userId = auth()->id();

        DB::statement("CALL insert_image('$request->text', '$imageName', '$userId')");
        $image->move(public_path('images'), $imageName);

        return redirect()->route('upload')->with('success', 'Imaginea a fost incarcata cu succes.');
    }

    public function create()
    {
        $images = Image::all();
        return view('gallery', compact('images'));
    }

    public function createForUser()
    {
        $user_id = Auth::id();
        $images = Image::where('user_id', $user_id)->get();
        return view('dashboard', compact('images'));
    }

    public function delete_img(Request $request)
    {
        $image_name = $request->route('id');
        Storage::delete('public/images/'.$image_name);
        Image::where('id', $image_name)->delete();
        return redirect()->back()->with('success', 'Image a fost stearsa cu succes!');
    }

    public function edit_img($id)
    {
    $image = Image::findOrFail($id);

    return view('edit', compact('image'));
    }

    public function update_img(Request $request, $id)
    {
    $request->validate([
        'text' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000'
    ]);

    $image = Image::findOrFail($id);

    $image->text = $request->text;

    if ($request->hasFile('image')) {
        $imageFile = $request->file('image');
        $filename = $imageFile->getClientOriginalName();
        $imageFile->move(public_path('/images'), $filename);
        $image->image = $filename;
    }

    $image->save();

    return redirect()->back()->with('success', 'Imaginea a fost actualizată cu succes');
    }

    public function search(Request $request)
    {
    $search = $request->input('search');
    $images = Image::where('text', 'like', '%' . $search . '%')->get();
    return view('search', compact('images'));
    }

}
