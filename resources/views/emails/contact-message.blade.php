@php
    $m = $contactMessage;
    $brand = st('brand.name', 'Brain-Tech');
    $mark = asset('Brain-Tech-Premium-Website/brand/mark-192.png');
    $accent = '#10d88e';
    $ink = '#14222d';
@endphp
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light only">
    <meta name="supported-color-schemes" content="light only">
    <title>New inquiry · {{ $brand }}</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td, a { font-family: Arial, sans-serif !important; }
    </style>
    <![endif]-->
</head>
<body style="margin:0;padding:0;background-color:#eef1f6;-webkit-font-smoothing:antialiased;">
    {{-- Hidden inbox preview text --}}
    <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:#eef1f6;opacity:0;">
        New inquiry from {{ $m->name }}@if ($m->service) · {{ $m->service }}@endif — reply directly from your inbox.
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#eef1f6;">
        <tr>
            <td align="center" style="padding:32px 14px;">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px;max-width:600px;background-color:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e4e8f0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">

                    {{-- Accent top bar --}}
                    <tr><td style="height:4px;background-color:{{ $accent }};line-height:4px;font-size:4px;">&nbsp;</td></tr>

                    {{-- Header --}}
                    <tr>
                        <td style="background-color:#0c0c11;padding:22px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="left" valign="middle">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td valign="middle"><img src="{{ $mark }}" width="32" height="32" alt="" style="display:block;border:0;width:32px;height:32px;"></td>
                                                <td valign="middle" style="padding-left:11px;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;font-size:20px;font-weight:700;letter-spacing:-0.01em;color:#ffffff;">Brain<span style="color:{{ $accent }};">Tech</span></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td align="right" valign="middle">
                                        <span style="display:inline-block;background-color:rgba(16,216,142,0.16);color:{{ $accent }};font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;padding:7px 13px;border-radius:999px;">New Inquiry</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Intro --}}
                    <tr>
                        <td style="padding:32px 32px 8px;">
                            <h1 style="margin:0 0 8px;font-size:22px;line-height:1.3;font-weight:700;color:{{ $ink }};letter-spacing:-0.02em;">You have a new message</h1>
                            <p style="margin:0;font-size:15px;line-height:1.6;color:#6b7280;">
                                <strong style="color:{{ $ink }};">{{ $m->name }}</strong> reached out through the website contact form.@if ($m->service) They’re interested in <strong style="color:{{ $ink }};">{{ $m->service }}</strong>.@endif
                            </p>
                        </td>
                    </tr>

                    {{-- Details card --}}
                    <tr>
                        <td style="padding:20px 32px 4px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f7f8fb;border:1px solid #eceef4;border-radius:12px;">
                                @php($rows = ['Name' => $m->name, 'Email' => $m->email, 'Company' => $m->company, 'Service' => $m->service])
                                @foreach ($rows as $label => $value)
                                    @if (filled($value))
                                        <tr>
                                            <td style="padding:14px 18px;{{ $loop->last ? '' : 'border-bottom:1px solid #eceef4;' }}font-size:12px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;color:#9aa0b0;width:96px;vertical-align:top;">{{ $label }}</td>
                                            <td style="padding:14px 18px 14px 0;{{ $loop->last ? '' : 'border-bottom:1px solid #eceef4;' }}font-size:15px;font-weight:600;color:{{ $ink }};vertical-align:top;">
                                                @if ($label === 'Email')
                                                    <a href="mailto:{{ $value }}" style="color:#0a9d68;text-decoration:none;">{{ $value }}</a>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    {{-- Message --}}
                    <tr>
                        <td style="padding:22px 32px 4px;">
                            <div style="font-size:12px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:#9aa0b0;margin-bottom:10px;">Message</div>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="background-color:#f7f8fb;border-left:3px solid {{ $accent }};border-radius:0 10px 10px 0;padding:18px 20px;font-size:15px;line-height:1.7;color:#1c2030;">{!! nl2br(e($m->message)) !!}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- CTA --}}
                    <tr>
                        <td style="padding:26px 32px 30px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" bgcolor="{{ $accent }}" style="border-radius:10px;">
                                        <a href="mailto:{{ $m->email }}?subject=Re:%20Your%20inquiry%20to%20{{ rawurlencode($brand) }}" style="display:inline-block;padding:14px 30px;font-size:14px;font-weight:700;color:#06351f;text-decoration:none;border-radius:10px;">Reply to {{ $m->name }} &rarr;</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:18px 32px 22px;background-color:#fafbfc;border-top:1px solid #eef0f5;">
                            <p style="margin:0 0 4px;font-size:12px;line-height:1.6;color:#9aa0b0;">
                                Submitted {{ $m->created_at?->format('M j, Y · g:i A') ?? now()->format('M j, Y · g:i A') }}@if ($m->locale) &nbsp;·&nbsp; Locale: {{ strtoupper($m->locale) }}@endif @if ($m->ip_address) &nbsp;·&nbsp; IP: {{ $m->ip_address }}@endif
                            </p>
                            <p style="margin:0;font-size:12px;line-height:1.6;color:#b3b8c4;">
                                This notification was sent automatically from the {{ $brand }} website contact form.
                            </p>
                        </td>
                    </tr>

                </table>

                <p style="margin:18px 0 0;font-size:11px;color:#aeb4c0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">© {{ date('Y') }} {{ $brand }}</p>

            </td>
        </tr>
    </table>
</body>
</html>
