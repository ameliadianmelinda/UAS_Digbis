<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();
        $search = $request->query('search');

        $transactions = Transaction::query()
            ->with('event')
            ->when($partner?->id, function ($query, $partnerId) {
                $query->whereHas('event', function ($eventQuery) use ($partnerId) {
                    $eventQuery->where('partner_id', $partnerId);
                });
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('order_id', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%")
                        ->orWhereHas('event', function ($eventQuery) use ($search) {
                            $eventQuery->where('title', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('created_at')
            ->get()
            ->map(function ($transaction) {
                $status = ucfirst((string) $transaction->status);

                return [
                    'id' => $transaction->id,
                    'order_id' => $transaction->order_id ?? '-',
                    'event_name' => $transaction->event?->title ?? '-',
                    'customer' => $transaction->customer_name ?? '-',
                    'email' => $transaction->customer_email ?? '-',
                    'phone' => $transaction->customer_phone ?? '-',
                    'total' => 'Rp ' . number_format((float) $transaction->total_price, 0, ',', '.'),
                    'status' => $status,
                    'date' => $transaction->created_at?->translatedFormat('d M Y') ?? '-',
                ];
            });

        return view('partner.transaksi', compact('transactions', 'search'));
    }

    public function export(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();
        $search = $request->query('search');

        $transactions = Transaction::query()
            ->with('event')
            ->when($partner?->id, function ($query, $partnerId) {
                $query->whereHas('event', function ($eventQuery) use ($partnerId) {
                    $eventQuery->where('partner_id', $partnerId);
                });
            }, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('order_id', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%")
                        ->orWhereHas('event', function ($eventQuery) use ($search) {
                            $eventQuery->where('title', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('created_at')
            ->get();

        $rows = collect([[
            'Order ID',
            'Nama Event',
            'Customer',
            'Email',
            'No. HP',
            'Total Pembayaran',
            'Status',
            'Tanggal Transaksi',
        ]]);

        foreach ($transactions as $transaction) {
            $rows->push([
                $transaction->order_id ?? '-',
                $transaction->event?->title ?? '-',
                $transaction->customer_name ?? '-',
                $transaction->customer_email ?? '-',
                $transaction->customer_phone ?? '-',
                'Rp ' . number_format((float) $transaction->total_price, 0, ',', '.'),
                ucfirst((string) $transaction->status),
                $transaction->created_at?->translatedFormat('d M Y H:i') ?? '-',
            ]);
        }

        // If ZipArchive is not available, fall back to CSV export (no PHP extension required)
        if (! class_exists('ZipArchive')) {
            $fileName = 'partner-transactions-' . now()->format('Ymd-His') . '.csv';

            $rowsArray = $rows->toArray();

            $callback = function () use ($rowsArray) {
                $out = fopen('php://output', 'w');
                foreach ($rowsArray as $row) {
                    // Ensure values are strings
                    $csvRow = array_map(function ($v) { return is_scalar($v) ? $v : json_encode($v); }, $row);
                    fputcsv($out, $csvRow);
                }
                fclose($out);
            };

            return response()->streamDownload($callback, $fileName, [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'no-store, no-cache',
            ]);
        }

        $package = $this->buildXlsxPackage($rows->toArray());
        $fileName = 'partner-transactions-' . now()->format('Ymd-His') . '.xlsx';

        return response($package, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    private function buildXlsxPackage(array $rows): string
    {
        $sheetXml = $this->buildWorksheetXml($rows);
        $workbookXml = $this->buildWorkbookXml();
        $workbookRelsXml = $this->buildWorkbookRelsXml();
        $contentTypesXml = $this->buildContentTypesXml();
        $relsXml = $this->buildRelsXml();

        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx');
        $zip = new ZipArchive();
        $zip->open($tmpFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('[Content_Types].xml', $contentTypesXml);
        $zip->addFromString('_rels/.rels', $relsXml);
        $zip->addFromString('xl/workbook.xml', $workbookXml);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $workbookRelsXml);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);
        $zip->close();

        $contents = file_get_contents($tmpFile);
        @unlink($tmpFile);

        return $contents;
    }

    private function buildWorksheetXml(array $rows): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
        $xml .= '<sheetData>';

        foreach ($rows as $rowIndex => $row) {
            $xml .= '<row r="' . ($rowIndex + 1) . '">';

            foreach ($row as $colIndex => $value) {
                $ref = chr(65 + $colIndex) . ($rowIndex + 1);
                $escaped = htmlspecialchars((string) $value, ENT_XML1);
                $xml .= '<c r="' . $ref . '" t="inlineStr"><is><t>' . $escaped . '</t></is></c>';
            }

            $xml .= '</row>';
        }

        $xml .= '</sheetData></worksheet>';

        return $xml;
    }

    private function buildWorkbookXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' .
            '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" ' .
            'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">' .
            '<sheets><sheet name="Transaksi" sheetId="1" r:id="rId1"/></sheets>' .
            '</workbook>';
    }

    private function buildWorkbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' .
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>' .
            '</Relationships>';
    }

    private function buildContentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' .
            '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">' .
            '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>' .
            '<Default Extension="xml" ContentType="application/xml"/>' .
            '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>' .
            '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>' .
            '</Types>';
    }

    private function buildRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' .
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>' .
            '</Relationships>';
    }

    public function show(Transaction $transaction)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $partner = $user?->partner()->first();

        if (! $transaction->event || $transaction->event->partner_id !== $partner?->id) {
            abort(404);
        }

        return view('partner.transaksi-show', compact('transaction'));
    }
}
