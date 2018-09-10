<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{

    private $extensionsList = ['jpg', 'png', 'gif', 'jpeg'];

    /**
     * Display a listing of the Files.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        $files = Files::all();
        return view('files.index')->with('files', $files);

    }

    /**
     * Show the form for creating a new File.
     *
     * @return Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created File in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $model = new Files();

        if ($request->hasFile('photo')) {
            // Get the file
            $file = $request->file('photo');
            // Extract all info needed for storing ... ;)
            $extension = $file->getClientOriginalExtension();
            $name = preg_replace("/[\s_]/", "-", basename($file->getClientOriginalName(), "." . $extension));
            $fileType = in_array($extension, $this->extensionsList) ? 'Images' : 'Others';
            $fileSize = $file->getClientSize();

            if (Storage::putFileAs('/public/' . $fileType, $file, $name. '.' . $extension)) {
                $file =  $model::create([
                    'name'      => $name,
                    'type'      => $fileType,
                    "extension" => $extension,
                    "size"      => $fileSize
                ]);
                return redirect(route('files.index'));
            }
        }
    }

    /**
     * Display the specified File.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified File.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $file = Files::findOrFail($id);
        return view('files.edit')->with('file', $file);
    }

    /**
     * Update the specified File in storage.
     *
     * @param  int              $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        // Create an instance of Files
        $model = new Files();

        //Find find by ID
        $file = $model::where('id', $id)->first();

        // Get Old file location
        $oldFile = '/public/'. $file->type . '/'. $file->name . '.' . $file->extension;

        // Check Request for File
        if ($request->hasFile('photo')) {

            // Get the uploaded file
            $uploadedFile = $request->file('photo');

            // Extract all info needed for storing ... ;)
            $extension = $uploadedFile->getClientOriginalExtension();
            $name      = preg_replace("/[\s_]/", "-", basename($uploadedFile->getClientOriginalName(), "." . $extension));
            $fileType  = in_array($extension, $this->extensionsList) ? 'Images': 'Others';
            $fileSize  = $uploadedFile->getClientSize();

            // Create location for new uploaded file
            $newFile = '/public/' . $fileType . '/' . $name . '.' . $extension;

            // Time to replace old file with new file
            // 1- Check if exists
            if (Storage::disk('local')->exists($oldFile)) {
                 // 2- Update old file with new one ;)
                if (Storage::disk('local')->move($oldFile, $newFile)) {
                    // 3- Store file information into DB
                    $file->name      = $name;
                    $file->type      = $fileType;
                    $file->extension = $extension;
                    $file->size      = $extension;
                    $file->save();

                    // Redirect back to index view
                    return redirect(route('files.index'));
                }
            }
        }
    }

   /**
     * Remove the specified File from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

    }
}
