<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $page->title }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #2e7d32; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { color: #2e7d32; font-size: 28px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; }
        .doc-type { color: #666; font-size: 10px; margin-top: 5px; }
        .title { font-size: 24px; color: #1a1a1a; margin-bottom: 10px; }
        .intro { font-size: 14px; color: #555; margin-bottom: 30px; font-style: italic; }
        .section { margin-bottom: 25px; }
        .section-title { font-size: 16px; color: #2e7d32; font-weight: bold; margin-bottom: 8px; border-left: 4px solid #2e7d32; padding-left: 10px; }
        .section-text { font-size: 13px; color: #444; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px; }
        .meta { text-align: right; font-size: 10px; color: #999; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">ECOVOLT ENERGY</div>
        <div class="doc-type">OFFICIAL DIGITAL DOCUMENT</div>
    </div>

    <div class="meta">
        REVISED DATE: {{ $content->date ?? 'N/A' }} | VERSION: {{ $content->version ?? '1.0' }}
    </div>

    <h1 class="title">{{ $content->main_title ?? $page->title }}</h1>
    
    <p class="intro">
        {{ $content->intro ?? '' }}
    </p>

    @if(isset($content->sections))
        @foreach($content->sections as $section)
        <div class="section">
            <div class="section-title">
                @if(isset($section->id)) {{ $section->id }}. @endif
                {{ $section->title }}
            </div>
            <div class="section-text">
                {{ $section->text }}
            </div>
        </div>
        @endforeach
    @endif

    <div class="footer">
        &copy; {{ date('Y') }} EcoVolt Energy. All rights reserved. | Generated on {{ date('d M, Y') }}
    </div>
</body>
</html>
