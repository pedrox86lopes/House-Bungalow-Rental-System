<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <title>Fatura - {{ $booking->bungalow->name }} - </title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            /* Important for supporting special characters like 'ç' */
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .company-info,
        .customer-info {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            margin-bottom: 20px;
        }

        .company-info {
            text-align: left;
        }

        .customer-info {
            text-align: right;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .details-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
        }

        .total-section p {
            margin: 5px 0;
            font-size: 12px;
        }

        .total-section .grand-total {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 9px;
            color: #777;
        }

        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('storage/bungalows/12.jpeg') }}" alt="BungalowRental" class="logo">
            <h1>FATURA</h1>
            <p><strong>Nº da Fatura:</strong> {{ $booking->invoice_number }}</p>
            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($booking->paid_at)->format('d/m/Y') }}</p>
        </div>

        <div class="company-info">
            <h3>Emitido por:</h3>
            <p>Nome da Empresa: Bungalow Rental</p>
            <p>NIF: 999999999</p>
            <p>Endereço: Instituto de Formação Braga</p>
            <p>Email: cesae@cesae.com</p>
            <p>Telefone: +351 999 999 999</p>
        </div>

        <div class="customer-info">
            <h3>Dados do Cliente</h3>
            <p>Nome: {{ $booking->user->name }}</p>
            <p>Email: {{ $booking->user->email }}</p>
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Bungalow</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Noites</th>
                    <th>Preço/Noite</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Reserva de Bungalow</td>
                    <td>{{ $booking->bungalow->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
                    <td>{{ $booking->number_of_nights }}</td>
                    <td>{{ number_format($booking->bungalow->price_per_night, 2, ',', '.') }} €</td>
                    <td>{{ number_format($booking->total_amount, 2, ',', '.') }} €</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <p>Subtotal: {{ number_format($booking->total_amount, 2, ',', '.') }} €</p>
            <p class="grand-total">Total: {{ number_format($booking->total_amount, 2, ',', '.') }} €</p>
        </div>

        <div class="footer">
            {{-- footer image --}}

            {{-- END Example SVG --}}
            <p>Obrigado pela sua reserva!</p>
            <p>Se tiver alguma dúvida, por favor contacte-nos.</p>
        </div>
    </div>
</body>

</html>
