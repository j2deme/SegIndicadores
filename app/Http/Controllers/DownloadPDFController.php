<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Spatie\LaravelPdf\Facades\Pdf;
use function Spatie\LaravelPdf\Support\pdf;
use Illuminate\Http\Request;

class DownloadPDFController extends Controller
{
    public function __invoke()
    {
        $registros = Registro::join('users', 'registros.user_id', '=', 'users.id')
            ->select('registros.*', 'users.name as user_name', 'users.apellidos as user_apellidos')
            ->where('users.departamento_id', auth()->user()->departamento_id)
            ->get();

        return Pdf::view('filament.pages.reportes', compact('registros'))
            ->download('registros.pdf');
    }
}
