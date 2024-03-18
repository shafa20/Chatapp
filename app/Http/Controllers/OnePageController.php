<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class OnePageController extends Controller
{
    public function index()
    {
        $images = Image::paginate(3);
        return view('images.index', compact('images'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $image = new Image();
        $image->name = $request->name;
        $image->description = $request->description;
        $image->image = $imageName;
        $image->save();


        return redirect()->route('onepage.index')->with('success', 'Post added successfully.');
    }
    public function update(Request $request, Image $onepage)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'new_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $onepage->name = $request->name;
        $onepage->description = $request->description;

        if ($request->hasFile('new_image')) {
            $request->validate([
                'new_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imageName = time() . '.' . $request->new_image->extension();
            $request->new_image->move(public_path('images'), $imageName);

            if ($onepage->image) {
                unlink(public_path('images/' . $onepage->image));
            }

            $onepage->image = $imageName;
        }

        $onepage->save();

        return redirect()->route('onepage.index')->with('success', 'Post updated successfully.');
    }
    public function destroy(Image $onepage)
    {

        if ($onepage->image) {
            unlink(public_path('images/' . $onepage->image));
        }

        $onepage->delete();

        return redirect()->route('onepage.index')->with('success','Post deleted successfully');
    }

}
