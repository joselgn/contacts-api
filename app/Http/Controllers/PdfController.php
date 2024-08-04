<?php

namespace App\Http\Controllers;


use App\Http\Services\IPdfService;
class PdfController
{
    private $pdfService;

    public function __construct(IPdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function process ()
    {
        $this->pdfService->read();
    }
}
