<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 2px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #676968;
            color: white;
        }
    </style>
</head>
<body>
<div class="logo">
    <span style="">{{ date('d/m/Y H:i') }}</span><br>
    <span style=" font-weight: bolder">Total :{{ $permissions->count() }}</span>
</div>

<center><h3>Liste des permissions </h3></center>
<table id="customers" style="width: 100%">
    <tr>
        <th>Employé</th>
        <th>Département</th>
        <th>Service</th>
        <th>Motif</th>
        <th class="numeric">Période</th>
        <th class="numeric">Date enreg.</th>
    </tr>
    @foreach($permissions as $permission)
        <tr role="row" >
            <td>{{ ucfirst($permission->employe->firstname ?? '').' '.ucfirst($permission->employe->lastname ?? '') }}</td>
            <td class="numeric">{{ ucfirst($permission->employe->departement->libelle ?? 'Aucun') }}</td>
            <td class="numeric">{{ ucfirst($permission->employe->service->libelle ?? 'Aucun') }}</td>
            <td class="numeric">{{ ucfirst($permission->motif)}}</td>
            <td class="numeric">Du {{ date('d/m/Y à H:i', strtotime($permission->debut)) }} <br> Au {{ date('d/m/Y à H:i', strtotime($permission->fin)) }}</td>
            <td class="numeric">{{ date('d/m/Y',strtotime($permission->created_at)) }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
