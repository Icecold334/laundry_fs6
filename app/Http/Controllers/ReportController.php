<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use App\Models\Orders;

class ReportController extends Controller
{
    // index
    public function index()
    {
        $data = [
            'title' => 'Laporan',
        ];
        return view('report.index', $data);
    }
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'Nomor');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Layanan');
        $sheet->setCellValue('E1', 'Jumlah');
        $sheet->setCellValue('F1', 'Total');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Pembayaran');

        // Retrieve data
        $orders = Orders::all();
        $row = 2;
        foreach ($orders as $key => $order) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $order->code);
            $sheet->setCellValue('C' . $row, $order->user->name);
            $sheet->setCellValue('D' . $row, $order->product->name);
            $sheet->setCellValue('E' . $row, $order->quantity);
            $sheet->setCellValue('F' . $row, $order->total);
            switch ($order->status) {
                case (0):
                    $status = 'Pesanan Dibuat';
                    break;

                case (1):
                    $status = 'Menunggu Pembayaran';
                    break;

                case (2):
                    $status = 'Pesanan Diproses';
                    break;

                case (3):
                    $status = 'Pesanan Siap Diambil';
                    break;

                case (4):
                    $status = 'Pesanan Selesai';
                    break;
            }
            $sheet->setCellValue('G' . $row, $status);
            $sheet->setCellValue('H' . $row, $order->method == 0 ? 'Tunai' : 'Non-Tunai');
            $row++;
        }

        // Save the file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'orders.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
