<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Http\Request;

use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class DownloadPDFController extends Controller
{
    public function download(Request $request)
    {
        $registros = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->where('users.departamento_id', auth()->user()->departamento_id)
            ->select('registros.*', 'users.name as user_name', 'users.apellidos as user_apellidos')
            ->get();

        $pdf = Pdf::view('filament.pages.pdf.reporte-departamento', compact('registros'));

        return $pdf->download('registros.pdf');
    }
}
