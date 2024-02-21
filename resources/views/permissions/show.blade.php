
<style type="text/css">
    *{font-family : "cambria","calibri","arial","sans-serif"; font-size : 11px; }

    table{
        margin: 0px;
        padding: 0px;
    }

    table.header{
        font-size: 15px;
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
    }

    .header h2{
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .header-last{
        width: 100%;
        border-collapse: collapse;
    }
    .header-last thead tr{
        background-color: {{ $setting->companycolor }};
        color: #fff;
    }

    .header-last thead tr th{
        padding: 10px;
        font-size: 18px;
    }

    .header-last td{
        padding: 10px;
    }

    img{
        width: 80px;
        height: 80px;
    }

    .date{
        margin: 25px 0 15px 5px;
    }
    .demandeur, .avis{
        border: 1px solid #505050;
        padding: 10px;
    }

    .underline{
        text-decoration: underline;
    }
    .right{
        text-align: right;
    }

    h4{
        font-size: 18px;
    }
     p, .underline{
         font-size: 14px;
     }
</style>

</head>
<body>
<div style="margin: 0px">
    <table class="header" cellpadding="0" border="1" style="border: 0px !important;margin: 0px">
        <tr>
            <td style="width: 15% !important; border: none !important; class="">
                <img src="{{ URL::to($setting->companylogo) }}" alt="{{ $setting->companyname }}">
            </td>
            <td style="width: 70% !important; text-align: center">
                <h2 style="text-align: center">DEMANDE DE PERMISSION</h2>
            </td>
            <td style="width: 15%">
                <table cellpadding="0" border="1" class="header-last" style="border: 0px !important;margin: 0px">
                    <thead>
                    <tr style="height: 100%">
                        <th>ERQ_O2 PS3-04</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Diffusion interne</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <div class="date">
        Date : ................................
    </div>
    <div class="demandeur">
        <h4>Demandeur</h4>
        <p>
            Nom et prénoms : {{$employe->firstname." ".$employe->lastname}}<br>
            Direction : {{$direction}}<br>
            Service : Aucun <br>
            Matricule : Aucun<br>
        </p>

        <p>
            <span class="underline">Période demandée :</span> <br>


            Nombre d'heures : {{$temps['hour']}}<br>
            Nombre de jours :{{$temps['day']}} <br>
        </p>
        <p>
            Motifs : {{$permission->motif}}<br>
        </p>
        <p class="right"><b>Signature : </b>.................................</p>
    </div>
    <div class="avis">
        <h4>Avis Hiérarchique</h4>
        <p>
            Accord du Supérieur Hérarchique N+1 : {{$permission->accord1==1?'OUI':'NON'}} <br>
            Nom, Date et Visa : ............................................. <br>
            Accord du Supérieur Hiérarchique N+2 : {{$permission->accord2==1?'OUI':'NON'}}<br>
            Nom, Date et Visa : ............................................. <br>
        </p>
    </div>
    <div class="avis">
        <h4>Avis du Directeur des Ressources Humaines</h4>
        <p>
            Accord du DRH : {{$permission->accord_drh==1?'OUI':'NON'}}<br>
            Absence à valoir sur : {{$permission->type_conge}}<br>
            Date et Visa : ............................................. <br>
        </p>
    </div>
    <div class="avis">
        <h4>Décision Direction Générale</h4>
        <p>
            Accord du DFC/DRH/DG : {{$permission->accord_dfc==1?'OUI':'NON'}}<br>
            Date et Signature : ............................................. <br>
        </p>
    </div>
</div>
<br>
</body>
</html>
