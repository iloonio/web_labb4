<?php include("includes/header.php"); ?>

<div class="textcontainer">
    <div class="textblock">
        <h1 class="h1text"> Digital gästbok med PHP & mySQL </h1>
    </div>
    <div class="textblock">
        <p> Labbet gick ut på att skapa ett sätt för 
            sidans besökare att kunna lägga in och ta bort inlägg på
            vår webbsida. </p> 
        
        <p> I vår header finns knappar som leder till
            de två olika lösningarna: Serial solution syftar på en
            metod där användaren skapar instanser av klassen TextPost som
            sedan blir konverterade till en sträng som läggs i en textfil.
            Database solution använder sig av en databas istället för en textfil
            för att sköta innehållet. </p> 
    </div>
</div>
<?php include ("includes/footer.php"); ?>
