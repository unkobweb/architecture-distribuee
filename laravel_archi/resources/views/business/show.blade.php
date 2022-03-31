<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Resultats</title>
</head>

<body>
    <nav class="nav">
        <p>Logo</p>
        <p>Nom</p>
        <p>truc1</p>
        <p>truc2</p>
    </nav>
    <h1>{{$business->name}}</h1>
    <div class="pres">
        <p class="address">Adresse : {{$business->address}} - {{$business->city}}</p>
        <p class="rating">Note moyenne : {{$business->rating}} / 5</p>
        <p class="Categories">Categories : {{$business->categories}}</p>
        <div class="infos">
            <h3>Informations complémentaires : </h3>
            <ul>
                @if($business->BusinessAcceptsCreditCards == true)
                <li>Cartes bancaires acceptées</li>
                @endif
                @if($business->RestaurantsReservations == true)
                <li>Réservations possibles</li>
                @endif
                @if($business->WheelchairAccessible == true)
                <li>Accessible en fauteuils roulants</li>
                @endif
                @if($business->OutdoorSeating != "None")
                <li>Places en terasse</li>
                @endif
                @if($business->HappyHour == true)
                <li>Happy hour à 18h</li>
                @endif
            </ul>
        </div>
    </div>
</body>

</html>