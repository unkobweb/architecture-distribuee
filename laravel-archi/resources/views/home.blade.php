<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <nav class="nav">
        <p>Logo</p>
        <p>Nom</p>
        <p>truc1</p>
        <p>truc2</p>
    </nav>
    <h1>Gros joli titre</h1>
    <div class="search">
        <form action="{{ route('search') }}" method="GET">
        @csrf
            <div class="values">
                <input class="geo" type="text" name="geo" id="" placeholder="Choisissez votre destination">
                <img src="https://cdn.pixabay.com/photo/2012/04/24/12/05/arrow-39651_1280.png" alt="">
                <select name="type" id="categ">
                    <option value="insolite">Insolite</option>
                    <option value="connu">Connu</option>
                </select>
                <select name="categ" id="categ">
                    <option value="categ1">categ1</option>
                    <option value="categ2">categ2</option>
                    <option value="categ3">categ3</option>
                    <option value="categ4">categ4</option>
                    <option value="categ5">categ5</option>
                </select>
            </div>
            <input class="valid" type="submit" value="Search 🔎">
        </form>
    </div>
</body>

</html>