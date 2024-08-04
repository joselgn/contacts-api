<?php

namespace App\Http\Services;


use App\Http\Services\IPdfService;
use Mpdf\Mpdf;
use Mpdf\Pdf;
use Smalot\PdfParser;
use Illuminate\Support\Facades\Storage;
class PdfService implements IPdfService
{
    private $mpdfService, $storage, $storageUploadFolder;
    public function __construct(PdfParser\Parser $mpdf)
    {
        $this->mpdfService = $mpdf;
        $this->storage = Storage::disk('public');
        $this->storageUploadFolder = env('STORAGE_UPLOAD');
    }

    public function read()
    {
        foreach ($this->storage->files($this->storageUploadFolder) as $filePath){
            if( str_contains('gitkeep', $filePath)){
                continue;
            }

            $file = $this->storage->get($filePath);

            if( !empty($file) ){
                $fileObj = $this->mpdfService->parseContent($file)->getPages();

                if( !empty($fileObj) ){

                    foreach($fileObj as $page){
                        dd($page->getText());
                    }

                    dd($filePath, $fileObj);
                }
            }
        }

    }
}
