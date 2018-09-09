<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{

    private $extensionsList = ['jpg', 'png', 'gif', 'jpeg'];

    /**
     * Get All Files
     */
    public function index()
    {
        $files = Files::all();
        return view('files')->with('files', $files);

    }

    /**
     * Store Files
     */
    public function store(Request $request)
    {
        $model = new Files();

        if ($request->hasFile('photo')) {
            // Get the file
            $file = $request->file('photo');
            // Extract all info needed for storing ... ;)
            $extension = $file->getClientOriginalExtension();
            $name = basename($file->getClientOriginalName(), "." . $extension);
            $fileType = in_array($extension, $this->extensionsList) ? 'Images' : 'Others';
            $fileSize = $file->getClientSize();

            if (Storage::putFileAs('/public/' . $fileType, $file, $name. '.' . $extension)) {
                return $model::create([
                    'name'      => $name,
                    'type'      => $fileType,
                    "extension" => $extension,
                    "size"      => $fileSize
                ]);
            }

            return back();
        }
    }
}
