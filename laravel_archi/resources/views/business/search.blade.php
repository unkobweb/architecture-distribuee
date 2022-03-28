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
    <h1>Résultats pour : {{$location}}</h1>
    <div class="results">
        @foreach($business as $place)
        <p>{{$place}}</p>
        <a href="/show/{{$place->business_id}}">
            <div class="business">
                @if(isset($place->image_url))
                <img class="business_img" src="{{$place->image_url}}" alt="">
                @else
                <img class="business_img" src="https://picsum.photos/1500/400" alt="">
                @endif
                <p><strong>{{$place->name}}</strong></p>
                <p>{{$place->address}} - {{$place->city}}</p>
                <p>{{$place->rating}}/5</p>
            </div>
        </a>
        @endforeach
    </div>
</body>

</html>