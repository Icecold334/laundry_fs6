<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportController extends Controller
{
    // index
    public function index(Request $request)
    {
        $orders = Orders::with(['product', 'user'])->where('status', '!=', 0)->orderBy('code')->get();
        $orders = $request->user ? $orders->where('user_id', $request->user) : $orders;
        $orders = $request->product ? $orders->where('product_id', $request->product) : $orders;
        $orders = $request->status ? $orders->where('status', $request->status) : $orders;
        $orders = $request->from || $request->to ? $orders->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']) : $orders;
        $data = [
            'title' => 'Laporan',
            'products' => Products::all(),
            'users' => User::where('role', 3)->get(),
            'user_name' => User::find($request->user)->name ?? 'Semua',
            'orders' => $orders,
        ];
        return view('report.index', $data);
    }
    public function export(Request $request)
    {
        $orders = Orders::with(['product', 'user'])->where('status', '!=', 0)->orderBy('code')->get();
        $orders = $request->user ? $orders->where('user_id',  $request->user) : $orders;
        $orders = $request->product ? $orders->where('product_id',  $request->product) : $orders;
        $orders = $request->status ? $orders->where('status',  $request->status) : $orders;
        $orders = $request->from || $request->to ? $orders->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']) : $orders;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator(Auth::user()->name)
            ->setLastModifiedBy(Auth::user()->name)
            ->setTitle(env('APP_NAME') . ' Report')
            ->setCategory('Report');
        $sheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->setCellValue('A1', 'LAPORAN PEMASUKAN ' . strtoupper(env("APP_NAME")));
        $sheet->mergeCells('A1:H1');
        if ($request->from || $request->to) {
            $sheet->setCellValue('A2', Carbon::parse($request->from)->isoFormat('DD MMMM Y') . ' / ' . Carbon::parse($request->to)->isoFormat('DD MMMM Y'));
            $sheet->mergeCells('A2:H2');
            $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
        $sheet->setCellValue('G3', 'Jumlah Pesanan');
        $sheet->getStyle('G3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue('H3', $orders->count());
        $sheet->getStyle('H3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G3:H3')->applyFromArray($styleArray);

        $sheet->setCellValue('G4', 'Total Pemasukan');
        $sheet->getStyle('G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue('H4', 'Rp ' . number_format($orders->sum('total'), 2, ',', '.'));
        $sheet->getStyle('H4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G4:H4')->applyFromArray($styleArray);

        // Set header row
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('8ea9db');
        $sheet->getStyle('A6:H6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('8ea9db');
        $sheet->setCellValue('A6', '#');
        $sheet->setCellValue('B6', 'Nomor');
        $sheet->setCellValue('C6', 'Nama');
        $sheet->setCellValue('D6', 'Layanan');
        $sheet->setCellValue('E6', 'Jumlah');
        $sheet->setCellValue('F6', 'Total');
        $sheet->setCellValue('G6', 'Status');
        $sheet->setCellValue('H6', 'Pembayaran');

        $row = 7;
        $i = 1;
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . $row - 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:H6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        foreach ($orders as $key => $order) {
            $sheet->setCellValue('A' . $row, $i++);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('B' . $row, $order->code);
            $sheet->setCellValue('C' . $row, $order->user->name);
            $sheet->setCellValue('D' . $row, $order->product->name);
            $sheet->setCellValue('E' . $row, $order->quantity . ' Kg');
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('F' . $row, 'Rp ' . number_format($order->total, 2, ',', '.'));
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
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
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);

        $sheet->getStyle('A1:H1')->applyFromArray($styleArray);
        $sheet->getStyle('A6:H' . $row - 1)->applyFromArray($styleArray);

        // Save the file
        $writer = new Xlsx($spreadsheet);
        $fileName = env('APP_NAME') . '_Report.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
