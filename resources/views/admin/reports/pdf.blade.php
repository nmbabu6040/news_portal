<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            color: #dc3545;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }

        .meta-info {
            margin-bottom: 15px;
            font-size: 11px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>সংবাদ ভিত্তিক রিপোর্ট</h2>
        <p>{{ $title }}</p>
    </div>

    <div class="meta-info">
        <strong>জেনারেট করার তারিখ:</strong> {{ date('d M Y, h:i A') }} <br>
        <strong>মোট নিউজ সংখ্যা:</strong> {{ count($articles) }} টি
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 47%;">শিরোনাম</th>
                <th style="width: 20%;">ক্যাটাগরি</th>
                <th style="width: 10%;">ভিউ</th>
                <th style="width: 15%;">তারিখ</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->category->name ?? 'N/A' }}</td>
                    <td>{{ $article->views ?? 0 }}</td>
                    <td>{{ $article->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">কোন তথ্য পাওয়া যায়নি।</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Report Generated Automatically | News Portal System</p>
    </div>

</body>

</html>
