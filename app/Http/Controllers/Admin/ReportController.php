<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Exports\ArticleReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // রিপোর্ট ফিল্টার ও প্রিভিউ পেজ
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'daily');

        $query = Article::with('category')->latest();

        if ($filter == 'daily') {
            $query->whereDate('created_at', now()->today());
        } elseif ($filter == 'weekly') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter == 'monthly') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($filter == 'yearly') {
            $query->whereYear('created_at', now()->year);
        }

        $articles = $query->paginate(15);

        return view('admin.reports.index', compact('articles', 'filter'));
    }

    // Excel & CSV এক্সপোর্ট
    public function exportExcelCsv(Request $request, $type, $format)
    {
        $fileName = 'Report_' . ucfirst($type) . '_' . date('Y-m-d');

        if ($format == 'csv') {
            return Excel::download(new ArticleReportExport($type), $fileName . '.csv', \Maatwebsite\Excel\Excel::CSV);
        }

        return Excel::download(new ArticleReportExport($type), $fileName . '.xlsx');
    }

    // PDF এক্সপোর্ট
    public function exportPdf($type)
    {
        $query = Article::with('category')->latest();

        if ($type == 'daily') {
            $query->whereDate('created_at', now()->today());
            $title = "দৈনিক রিপোর্ট (" . date('d M Y') . ")";
        } elseif ($type == 'weekly') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $title = "সাপ্তাহিক রিপোর্ট (" . now()->startOfWeek()->format('d M') . " - " . now()->endOfWeek()->format('d M Y') . ")";
        } elseif ($type == 'monthly') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            $title = "মাসিক রিপোর্ট (" . date('F Y') . ")";
        } elseif ($type == 'yearly') {
            $query->whereYear('created_at', now()->year);
            $title = "বাৎসরিক রিপোর্ট (" . date('Y') . ")";
        }

        $articles = $query->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('articles', 'title', 'type'));

        return $pdf->download('Report_' . ucfirst($type) . '_' . date('Y-m-d') . '.pdf');
    }
}
