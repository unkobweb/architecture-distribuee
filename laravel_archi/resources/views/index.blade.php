<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/style.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <div class="search">
        <form action="{{ route('search') }}" method="GET">
        @csrf
            <div class="values">
                <label for="geo" class="question">Dans quelle ville cherchez-vous ?</label>
                <input class="geo" type="text" name="geo" id="geo" placeholder="Nantes, San francisco">
                <!-- <select name="type" id="categ">
                    <option value="insolite">Insolite</option>
                    <option value="connu">Connu</option>
                </select>
                <select name="categ" id="categ">
                    <option value="categ1">categ1</option>
                    <option value="categ2">categ2</option>
                    <option value="categ3">categ3</option>
                    <option value="categ4">categ4</option>
                    <option value="categ5">categ5</option>
                </select> -->
            </div>
            <div class="switch-container">
                <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider round"></span>
                </label>
                <p>Lieux insolites</p>
            </div>
            <input class="valid" type="submit" value="Rechercher 🔎">
        </form>
    </div>
</body>

</html>