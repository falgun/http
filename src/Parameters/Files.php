<?php
declare(strict_types=1);

namespace Falgun\Http\Parameters;

class Files extends AbstractValueBag
{

    public function __construct(array $files)
    {
        parent::__construct($this->prepareBetterFileArray($files));
    }

    private function prepareBetterFileArray(array $files)
    {
        $betterArray = [];

        foreach ($files as $field => $fileArray) {
            foreach ($fileArray['name'] as $key => $fileName) {
                $file = [];
                $file['name'] = $fileName;
                $file['type'] = $files[$field]['type'][$key];
                $file['tmp_name'] = $files[$field]['tmp_name'][$key];
                $file['error'] = $files[$field]['error'][$key];
                $file['size'] = $files[$field]['size'][$key];

                $betterArray[$field][] = $file;
            }
        }

        return $betterArray;
    }
}
