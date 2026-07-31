<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 4px;
        }
        .info {
            margin-bottom: 16px;
            color: #555;
        }
        .rang {
            float: right;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Bulletin scolaire — SchoolNote</h1>

    <div class="info">
        <strong>{{ $eleve->name }}</strong> —
        {{ $eleve->classe->nom ?? '—' }} —
        Semestre {{ $semestre }}

        @if ($rang)
            <span class="rang">Rang : {{ $rang['rang'] }} / {{ $rang['total'] }}</span>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Coefficient</th>
                <th>Moyenne / 20</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($moyennesParMatiere as $ligne)
                <tr>
                    <td>{{ $ligne['matiere'] }}</td>
                    <td>{{ $ligne['coefficient'] }}</td>
                    <td>{{ $ligne['moyenne'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Moyenne générale</td>
                <td>{{ $moyenneGenerale }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>