<?php

namespace App\Http\Controllers;

use App\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
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
            $file      = $request->file('photo');
            // Extract all info needed for storing ... ;)
            $extension = $file->getClientOriginalExtension();
            // Check Files Model for convertWhiteSpaceToHyphen, getFileType functions :)
            $name      = $model->convertWhiteSpaceToHyphen($file->getClientOriginalName(), $extension);
            $fileType  = $model->getFileType($extension);
            $fileSize  = $file->getClientSize();

            $path = $file->storeAs('/public/'. $fileType, $name . '.' . $extension);

            if ($path) {
                $file =  $model::create([
                    'name'      => $name,
                    'type'      => $fileType,
                    "extension" => $extension,
                    "size"      => $fileSize
                ]);
                return redirect(route('files.index'));
            }
            return back();
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
            $name      = $model->convertWhiteSpaceToHyphen($uploadedFile->getClientOriginalName(), $extension);
            $fileType  = $model->getFileType($extension);
            $fileSize  = $uploadedFile->getClientSize();

            // Delete old File

            $deletedPath = Storage::disk('local')->delete($oldFile);

            // If old file deleted, store the new uploaded file ;)
            if ($deletedPath) {
                    Storage::putFileAs('/public/' . $fileType . '/', $uploadedFile , $name . '.' . $extension);
                    $file->name      = $name;
                    $file->type      = $fileType;
                    $file->extension = $extension;
                    $file->size      = $fileSize;
                    $file->save();
                return redirect(route('files.index'));
            }
            return back();
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
