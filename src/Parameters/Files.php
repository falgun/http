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

            if (is_array($fileArray['name'])) {
                // multiple file
                $betterArray[$field] = $this->prepareMultiFileArray($fileArray);
                continue;
            }

            $betterArray[$field] = File::fromArray($fileArray);
        }

        return $betterArray;
    }

    private function prepareMultiFileArray(array $fileArray)
    {
        $multiFiles = [];

        foreach ($fileArray['name'] as $key => $fileName) {
            $file = new File(
                $fileName,
                $fileArray['type'][$key],
                $fileArray['tmp_name'][$key],
                $fileArray['size'][$key],
                $fileArray['error'][$key],
            );

            $multiFiles[] = $file;
        }

        return $multiFiles;
    }
}
