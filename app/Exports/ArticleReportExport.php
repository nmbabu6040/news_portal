<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArticleReportExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function query()
    {
        $query = Article::with('category')->latest();

        switch ($this->type) {
            case 'daily':
                $query->whereDate('created_at', now()->today());
                break;
            case 'weekly':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'yearly':
                $query->whereYear('created_at', now()->year);
                break;
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'শিরোনাম (Title)',
            'ক্যাটাগরি (Category)',
            'ভিউ সংখ্যা (Views)',
            'স্ট্যাটাস (Status)',
            'প্রকাশের তারিখ (Date)',
        ];
    }

    public function map($article): array
    {
        return [
            $article->id,
            $article->title,
            $article->category->name ?? 'N/A',
            $article->views ?? 0,
            $article->status ?? 'Published',
            $article->created_at->format('d M Y, h:i A'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'DC3545']
                ]
            ],
        ];
    }
}
