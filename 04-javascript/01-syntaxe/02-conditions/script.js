"use strict";
/* 
    Math.random() génère un chiffre entre 0 et 1
    Math.floor() arrondi à l'inferieur
*/
const x = Math.floor(Math.random()*100);
// const x = 50;
console.log(x);

/* 
    Une condition commencera forcément par un "if" suivi de parenthèses.
    Dans ces parenthèses se trouverons la condition à vérifier.
    Si elle est vrai, alors ce qui se trouve entre accolade sera exécuté
    sinon il ne se passera rien.
*/
if(x < 50)
{
    console.log("x est plus petit que 50");
}
/* 
    Si on a plusieurs conditions à vérifier, on peut faire suivre un if,
    de un ou plusieurs "else if" qui ne seront vérifié, que si toute les conditions précédentes sont fausses.
*/
else if(x > 50)
{
    console.log("x est plus grand que 50");
}
/* 
    Si on le souhaite, on peut ajouter un "else" qui ne prend aucune condition,
    Il sera executé, si toute les conditions précédentes sont fausses.
*/
else
{
    console.log("x vaut 50");
}

/* 
    Si la condition, n'a qu'une seule instruction à réaliser.
    On peut ne pas mettre les accolades.
*/
if(x<50)
    console.log("x est plus petit que 50");    
else if(x > 50)
    console.log("x est plus grand que 50");
else
    console.log("x vaut 50");

/* 
    Une ternaire est une condition sur une seule ligne.
    Elle s'écrit :
        condition ? valeurSiTrue : valeurSiFalse
*/
const message1 = x<=50?"x est plus petit ou égale à 50":"x est plus grand que 50";
console.log(message1);
/* 
    On peut imbriquer des ternaires, mais si on perd en lisibilité, c'est plutôt déconseillé
*/
const message2 = 
    x < 50 ?
        "x est plus petit que 50" :
        x > 50 ?
            "x est plus grand que 50":
            "x vaut 50";
console.log(message2);

// Opérateur de Coalescence (??)
let a, b = undefined, c = null, d = "J'aime la pizza";
/* 
    Il permet de vérifier si une variable contient une valeur.
    Et dans le cas où la variable est vide, de prendre la valeur qui suis les "??".
*/
console.log(
    a ?? "Coucou de a",
    b ?? "Coucou de b",
    c ?? "Coucou de c",
    d ?? "Coucou de d"
);
// opérateur de chaînage optionnelle "?."
const   obj = {info: "cet objet est un exemple", superinfo: {a:"rien à dire"}},
        obj2={},
        obj3 = null;
/* 
    L'opérateur de chaînage optionnelle permet de vérifier l'existence de l'objet qui précède l'opérateur, avant de tenter de demander une propriété sur celui ci.
*/
console.log(
    obj.info,
    obj.superinfo.a,
    obj.fake?.info,
    obj2.superinfo?.a,
    obj3?.info
);

// ? Switch 
// prompt permet d'afficher une modale invitant l'utilisateur à rentrer une information, cette dernière sera retourné et peut être utilisée par exemple dans une variable.
let ville = prompt("De quelle ville venez-vous?");
// if(ville === "" || ville === null) {ville = "sans réponse}";
ville = ville??"sans réponse";

console.log(ville);
/* 
    le switch permet de prendre une valeur entre parenthèse.
    Puis de déclarer plusieurs cas possibles.
    chacun de ces cas doit être terminé par un "break";
    Si plusieurs cas s'enchainent sans break, alors ils réaliseront les mêmes actions.
    On peut ajouter un "default" qui sera lancé si aucun cas ne correspond
*/
switch(ville.toLowerCase())
{
    case "bordeaux":
    case "lille":
        console.log("C'est trop bien");
        break;
    case "paris":
        console.log("C'est pas bien");
        break;
    default:
        console.log("Je ne connais pas");
}

// alert("Message casse pied");
// console.log(confirm("Vous avez bien compris?"));
    