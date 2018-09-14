<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $fillable = [
        'name', 'type', 'size', 'extension'
    ];

    private $imageExtensions = ['jpg', 'png', 'gif', 'jpeg'];

    /**
     * Get File type by providing extension
     * @param  string      $extension File extension
     * @return string      Type
     * TODO: Add support for more extensions
     */
    public function getFileType($extension)
    {
        if (in_array($extension, $this->imageExtensions)) {
            return 'images';
        }else {
            return 'others';
        }
    }

    /**
     * Get File type by providing extension
     * @param  string      $fileName File name
     * @param  string      $extension File extension
     * @return string      File Name
     */
    public function convertWhiteSpaceToHyphen($fileName, $extension)
    {
        return preg_replace("/[\s_]/", "-", basename($fileName, "." . $extension));
    }


}
