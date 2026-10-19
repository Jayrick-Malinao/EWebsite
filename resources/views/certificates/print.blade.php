<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $certificate->certificate_number }} | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           PRINT CERTIFICATE & CONTROL BAR DESIGN
        ========================================================= */

        :root {
            --primary: #168B70;
            --primary-dark: #0F6F5A;
            --border-white: rgba(255, 255, 255, 0.90);
            --shadow-dark: rgba(107, 134, 124, 0.18);
            --shadow-light: rgba(255, 255, 255, 0.92);
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: #EEF5F1;
            color: #164238;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* ---------- Clay Control Bar (Screen Only) ---------- */
        .print-control-bar {
            display: flex;
            align-items: center;
            justify-content: justify-between;
            gap: 16px;
            max-width: 210mm;
            margin: 20px auto 10px;
            padding: 16px 24px;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: 20px;
            box-shadow: 6px 6px 16px var(--shadow-dark), -6px -6px 16px var(--shadow-light);
        }

        .clay-btn-print {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 0.6rem 1.25rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 700;
            color: #FFFFFF !important;
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: 4px 4px 10px rgba(15, 76, 58, 0.22), -3px -3px 8px rgba(255, 255, 255, 0.55);
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-btn-print:hover { transform: translateY(-1px); filter: brightness(1.05); }

        .clay-btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 0.6rem 1.25rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 700;
            color: #0F6F5A !important;
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.94);
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.18s ease, background 0.18s ease;
        }
        .clay-btn-back:hover { transform: translateY(-1px); background: linear-gradient(145deg, #FFFFFF, #EEF6F2); }

        /* ---------- Printable Document Structure ---------- */
        .certificate-page {
            width: 210mm;
            min-height: 297mm;
            margin: 10px auto 30px;
            padding: 14mm;
            background: #ffffff;
            box-shadow: 8px 8px 24px rgba(107, 134, 124, 0.15);
        }

        .certificate-border {
            width: 100%;
            min-height: 269mm;
            padding: 9mm;
            border: 3px double #0F4C3A;
            position: relative;
        }

        .certificate-inner-border {
            width: 100%;
            min-height: 249mm;
            padding: 10mm;
            border: 1px solid #168B70;
        }

        .header {
            text-align: center;
        }

        .republic {
            margin: 0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #374151;
        }

        .province {
            margin: 3px 0 0;
            font-size: 11px;
            color: #374151;
        }

        .barangay {
            margin: 4px 0 0;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #0F4C3A;
        }

        .health-center {
            margin: 3px 0 0;
            font-size: 12px;
            font-weight: 700;
            color: #168B70;
        }

        .divider {
            width: 90px;
            height: 2px;
            margin: 12px auto 16px;
            background: #E87928;
        }

        .title {
            margin: 0;
            text-align: center;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #0F4C3A;
            text-transform: uppercase;
        }

        .certificate-type {
            margin: 6px 0 0;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: #168B70;
        }

        .certificate-number {
            margin-top: 10px;
            text-align: center;
            font-family: "Courier New", monospace;
            font-size: 11px;
            font-weight: 700;
            color: #6B7280;
        }

        .body {
            margin-top: 24px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 14px;
            line-height: 1.75;
            text-align: justify;
            color: #1F2937;
        }

        .body p {
            margin: 0 0 14px;
        }

        .resident-name {
            font-weight: 700;
            text-transform: uppercase;
            color: #0F4C3A;
        }

        .resident-detail {
            font-weight: 700;
        }

        .purpose-box {
            margin: 18px 0;
            padding: 12px 16px;
            border-left: 4px solid #168B70;
            background: #F2F9F6;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.55;
        }

        .purpose-label {
            display: block;
            margin-bottom: 4px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #168B70;
        }

        .remarks {
            margin-top: 16px;
            padding: 12px 16px;
            border: 1px solid #D2E1DA;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.55;
            background: #FAFCFB;
        }

        .remarks-label {
            display: block;
            margin-bottom: 4px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #6B7280;
        }

        .date-issued {
            margin-top: 22px !important;
            font-size: 13px;
        }

        .signature-area {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 35px;
            margin-top: 45px;
        }

        .signature {
            min-width: 0;
            text-align: center;
        }

        .signature-line {
            width: 80%;
            height: 1px;
            margin: 0 auto 7px;
            background: #1F2937;
        }

        .signature-name {
            margin: 0;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #111827;
        }

        .signature-role {
            margin: 3px 0 0;
            font-size: 10px;
            color: #6B7280;
        }

        .footer {
            margin-top: 28px;
            text-align: center;
            font-size: 8px;
            line-height: 1.45;
            color: #6B7280;
        }

        .footer p {
            margin: 0;
        }

        .footer-number {
            margin-top: 4px !important;
            font-family: "Courier New", monospace;
            font-weight: 700;
            color: #374151;
        }

        /* ---------- PRINT STYLES ---------- */
        @media print {
            html, body {
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                padding: 0;
                background: #ffffff;
            }

            .print-control-bar {
                display: none !important;
            }

            .certificate-page {
                display: block;
                width: 210mm;
                min-height: 297mm;
                height: 297mm;
                margin: 0;
                padding: 14mm;
                background: #ffffff;
                box-shadow: none;
                page-break-after: avoid;
                page-break-inside: avoid;
            }

            .certificate-border {
                min-height: 269mm;
                height: 269mm;
                page-break-inside: avoid;
            }

            .certificate-inner-border {
                min-height: 249mm;
                height: 249mm;
                page-break-inside: avoid;
            }

            .body, .signature-area, .footer {
                page-break-inside: avoid;
            }
        }

        @media screen and (max-width: 900px) {
            .print-control-bar {
                width: 92%;
                margin: 15px auto;
            }

            .certificate-page {
                width: 100%;
                min-height: auto;
                padding: 15px;
            }

            .certificate-border {
                min-height: auto;
                padding: 10px;
            }

            .certificate-inner-border {
                min-height: auto;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    {{-- TOP CONTROL BAR --}}
    <div class="print-control-bar">
        <div>
            <p style="margin: 0; font-size: 11px; font-weight: 700; color: #168B70; text-transform: uppercase; letter-spacing: 0.05em;">Certificate Preview</p>
            <p style="margin: 2px 0 0; font-size: 14px; font-weight: 700; color: #164238;">{{ $certificate->certificate_number }}</p>
        </div>

        <div style="display: flex; items-center; gap: 10px;">
            <a href="{{ route('certificates.show', $certificate) }}" class="clay-btn-back">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Back to Details
            </a>

            <button type="button" class="clay-btn-print" onclick="window.print()">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m11.32-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.592 0-1.082-.456-1.12-1.047L6.34 18m11.32 0H6.34m0 0L5.34 10.5M17.66 18l1-7.5M18.75 10.5h.008v.008h-.008V10.5Zm-13.5 0h.008v.008H5.25V10.5Z" />
                </svg>
                Print Certificate
            </button>
        </div>
    </div>

    {{-- PRINTABLE DOCUMENT --}}
    <main class="certificate-page">
        <div class="certificate-border">
            <div class="certificate-inner-border">

                <header class="header">
                    <p class="republic">REPUBLIC OF THE PHILIPPINES</p>
                    <p class="province">Province of Sorsogon</p>
                    <p class="barangay">Barangay Esperanza</p>
                    <p class="health-center">Barangay Esperanza Health Center</p>

                    <div class="divider"></div>

                    <h1 class="title">Certificate</h1>
                    <p class="certificate-type">{{ $certificate->certificate_type }}</p>
                    <p class="certificate-number">Certificate No. {{ $certificate->certificate_number }}</p>
                </header>

                <section class="body">
                    <p>TO WHOM IT MAY CONCERN:</p>

                    <p>
                        This is to certify that
                        <span class="resident-name">{{ $certificate->resident->full_name }}</span>
                        is a registered resident of Barangay Esperanza, Pilar, Sorsogon, based on the records maintained by the Barangay Esperanza Health Center.
                    </p>

                    @if ($certificate->resident->birth_date || $certificate->resident->gender)
                        <p>
                            The resident's recorded information includes
                            @if ($certificate->resident->birth_date)
                                a birth date of <span class="resident-detail">{{ $certificate->resident->birth_date->format('F d, Y') }}</span>
                            @endif
                            @if ($certificate->resident->birth_date && $certificate->resident->gender)
                                and
                            @endif
                            @if ($certificate->resident->gender)
                                a gender of <span class="resident-detail">{{ $certificate->resident->gender }}</span>
                            @endif.
                        </p>
                    @endif

                    @if ($certificate->resident->household)
                        <p>
                            The resident is associated with household
                            <span class="resident-detail">{{ $certificate->resident->household->household_code }}</span>
                            at the recorded address of
                            <span class="resident-detail">{{ $certificate->resident->household_address ?? $certificate->resident->household->address ?? 'Barangay Esperanza, Pilar, Sorsogon' }}</span>.
                        </p>
                    @endif

                    <p>This certificate is issued upon the request of the above-named person for whatever lawful purpose it may serve.</p>

                    @if ($certificate->purpose)
                        <div class="purpose-box">
                            <span class="purpose-label">Purpose of Certification</span>
                            {{ $certificate->purpose }}
                        </div>
                    @endif

                    @if ($certificate->remarks)
                        <div class="remarks">
                            <span class="remarks-label">Remarks</span>
                            {{ $certificate->remarks }}
                        </div>
                    @endif

                    <p class="date-issued">
                        Issued this
                        <strong>{{ $certificate->date_issued?->format('jS') }}</strong>
                        day of
                        <strong>{{ $certificate->date_issued?->format('F Y') }}</strong>
                        at Barangay Esperanza, Pilar, Sorsogon.
                    </p>
                </section>

                <section class="signature-area">
                    <div class="signature">
                        <div class="signature-line"></div>
                        <p class="signature-name">{{ $certificate->issuer->name ?? 'Authorized Representative' }}</p>
                        <p class="signature-role">Issued By</p>
                    </div>

                    <div class="signature">
                        <div class="signature-line"></div>
                        <p class="signature-name">Barangay Esperanza Health Center</p>
                        <p class="signature-role">Barangay Health Center</p>
                    </div>
                </section>

                <footer class="footer">
                    <p>This certificate is an official record issued by the Barangay Esperanza Health Center.</p>
                    <p>For verification, please present the certificate number to the authorized health center personnel.</p>
                    <p class="footer-number">{{ $certificate->certificate_number }}</p>
                </footer>

            </div>
        </div>
    </main>

</body>
</html>