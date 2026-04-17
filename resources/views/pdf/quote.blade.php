<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quote - {{ $quote->proposal_id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; padding: 20px; }
        .header { display: table; width: 100%; border-bottom: 3px solid #2e7d32; padding-bottom: 20px; margin-bottom: 30px; }
        .logo-cell { display: table-cell; vertical-align: middle; }
        .info-cell { display: table-cell; text-align: right; vertical-align: middle; }
        .logo { color: #2e7d32; font-size: 32px; font-weight: bold; }
        .proposal-title { font-size: 20px; color: #1a1a1a; margin: 0; }
        .date { font-size: 12px; color: #666; }
        
        .client-info { margin-bottom: 30px; }
        .client-label { font-size: 10px; color: #999; text-transform: uppercase; margin-bottom: 5px; }
        .client-name { font-size: 16px; font-weight: bold; }

        .summary-card { background: #f9fbf9; padding: 25px; border-radius: 15px; margin-bottom: 35px; border: 1px solid #edf5ed; }
        .package-name { font-size: 22px; color: #1a1a1a; font-weight: bold; margin-bottom: 15px; }
        .price-wrap { font-size: 28px; color: #2e7d32; font-weight: bold; }
        .price-label { font-size: 12px; color: #666; font-weight: normal; }

        .section-header { font-size: 16px; font-weight: bold; color: #1a1a1a; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        
        .grid { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .grid td { width: 50%; padding: 15px; border: 1px solid #f1f1f1; }
        .component-title { font-weight: bold; color: #2e7d32; font-size: 14px; }
        .component-desc { font-size: 12px; color: #666; }

        .timeline-box { background: #fff8e1; padding: 20px; border-radius: 10px; border-left: 5px solid #ffc107; font-size: 13px; margin-bottom: 40px; }
        
        .footer { text-align: center; font-size: 11px; color: #999; margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-cell">
            <div class="logo">ECOVOLT</div>
            <div class="proposal-title">INVESTMENT PROPOSAL</div>
        </div>
        <div class="info-cell">
            <div class="date">Proposal ID: #{{ $quote->proposal_id }}</div>
            <div class="date">Issued Date: {{ $quote->quote_date->format('M d, Y') }}</div>
        </div>
    </div>

    <div class="client-info">
        <div class="client-label">Prepared for:</div>
        <div class="client-name">{{ $quote->user->name }}</div>
        <div class="date">{{ $quote->user->email }}</div>
    </div>

    <div class="summary-card">
        <div class="package-name">{{ $quote->package_name }}</div>
        <div class="price-wrap">${{ number_format($quote->total_price, 2) }} <span class="price-label">/incl tax</span></div>
    </div>

    <div class="section-header">COMPONENT BREAKDOWN</div>
    <table class="grid">
        <tr>
            <td>
                <div class="component-title">Solar Panels</div>
                <div class="component-desc">{{ $quote->components['panels'] ?? 'N/A' }}</div>
            </td>
            <td>
                <div class="component-title">Hybrid Inverter</div>
                <div class="component-desc">{{ $quote->components['inverter'] ?? 'N/A' }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="component-title">Battery Storage</div>
                <div class="component-desc">{{ $quote->components['battery'] ?? 'N/A' }}</div>
            </td>
            <td>
                <div class="component-title">System Warranty</div>
                <div class="component-desc">{{ $quote->components['warranty'] ?? 'N/A' }}</div>
            </td>
        </tr>
    </table>

    <div class="section-header">PROJECT TIMELINE</div>
    <div class="timeline-box">
        {{ $quote->timeline ?? 'Flexible installation within 14-21 business days.' }}
    </div>

    <div class="footer">
        This is a digitally generated document. Acceptance of this quote on the EcoVolt App constitutes a formal agreement.<br>
        EcoVolt Energy Solutions | www.ecovolt-solar.com
    </div>
</body>
</html>
