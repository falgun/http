<?php
declare(strict_types=1);

namespace Falgun\Http\Tests;

use Falgun\Http\Request;
use Falgun\Http\Parameters\File;
use PHPUnit\Framework\TestCase;

class UploadedFileTest extends TestCase
{

    public function testUploadedSingleFile()
    {
        $_FILES = [
            'file1' => [
                'name' => 'MyFile1.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/php/php6hst32',
                'error' => UPLOAD_ERR_OK,
                'size' => 98174,
            ],
        ];

        $request = Request::createFromGlobals();

        $expected = new File(
            'MyFile1.jpg',
            'image/jpeg',
            '/tmp/php/php6hst32',
            98174,
            UPLOAD_ERR_OK,
        );

        $this->assertEquals($expected, $request->files()->get('file1'));
    }

    public function testUploadedMultiFileList()
    {
        $_FILES = [
            'file1' => [
                'name' => 'MyFile1.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/php/php6hst32',
                'error' => UPLOAD_ERR_OK,
                'size' => 98174,
            ],
            'file2' => [
                'name' => 'MyFile2.png',
                'type' => 'image/png',
                'tmp_name' => '/tmp/php/php6hst33',
                'error' => UPLOAD_ERR_OK,
                'size' => 15555,
            ],
        ];

        $request = Request::createFromGlobals();

        $expectedFile1 = new File(
            'MyFile1.jpg',
            'image/jpeg',
            '/tmp/php/php6hst32',
            98174,
            UPLOAD_ERR_OK,
        );
        $expectedFile2 = new File(
            'MyFile2.png',
            'image/png',
            '/tmp/php/php6hst33',
            15555,
            UPLOAD_ERR_OK,
        );

        $this->assertEquals($expectedFile1, $request->files()->get('file1'));
        $this->assertEquals($expectedFile2, $request->files()->get('file2'));
    }

    public function testUploadedFileArrayList()
    {

        $_FILES = [
            'file1' => [
                'name' => [
                    0 => 'MyFile1.jpg',
                    1 => 'MyFile2.jpg'
                ],
                'type' => [
                    0 => 'image/jpeg',
                    1 => 'image/png'
                ],
                'tmp_name' => [
                    0 => '/tmp/php/php6hst32',
                    1 => '/tmp/php/php6hst33'
                ],
                'error' => [
                    0 => UPLOAD_ERR_OK,
                    1 => UPLOAD_ERR_OK
                ],
                'size' => [
                    0 => 98174,
                    1 => 15555
                ],
            ],
        ];


        $request = Request::createFromGlobals();

        $expected = [
            0 => new File(
                'MyFile1.jpg',
                'image/jpeg',
                '/tmp/php/php6hst32',
                98174,
                UPLOAD_ERR_OK,
            ),
            1 => new File(
                'MyFile2.jpg',
                'image/png',
                '/tmp/php/php6hst33',
                15555,
                UPLOAD_ERR_OK,
            )
        ];

        $this->assertEquals($expected, $request->files()->get('file1'));
    }
}
