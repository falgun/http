<?php
declare(strict_types=1);

namespace Falgun\Http\Parameters;

class Files extends AbstractValueBag
{

    public function __construct(array $files)
    {
        parent::__construct($this->prepareBetterFileArray($files));
    }

    private function prepareBetterFileArray(array $files): array
    {
        $betterArray = [];

        foreach ($files as $field => $fileArray) {
            foreach ($fileArray['name'] as $key => $fileName) {
                $file = new File(
                    $fileName,
                    $files[$field]['type'][$key],
                    $files[$field]['tmp_name'][$key],
                    $files[$field]['size'][$key],
                    $files[$field]['error'][$key],
                );

                $betterArray[$field][] = $file;
            }
        }

        return $betterArray;
    }
}
