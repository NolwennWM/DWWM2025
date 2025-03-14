"use strict";
/* 
    Une fonction est un morceau de code nommé, 
    que l'on peut appeler où l'on souhaite dans notre code.
    Une fonction se déclare avec le mot clef "function" suivi d'un nom au choix, de parenthèses puis d'accolades.

    Tant que la fonction n'est pas appelé, le code ne sera pas exécuté.
    Une fonction peut être appelé avant ou après sa déclaration.
*/
salut();
function salut()
{
    console.log("Salut les gens");    
}
salut();
/* 
    Il existent d'autres façons de déclaré des fonctions.
    Mais les façons suivantes, ne peuvent être appelé qu'après leurs déclarations.

    On pourra déclarer une fonction dite "anonyme" et la ranger dans une variable, un objet, ou un tableau (bien que celui ci, ne se voit jamais).
*/
const salut2 = function()
{
    console.log("Salut anonyme !");    
}
salut2();
/* 
    Il existe une version raccourci de la fonction anonyme,
    on appelle cela une fonction fléché
*/
const salut3 = ()=>{
    console.log("Salut fléché !");
}
salut3();
// exemple de fonction dans un objet :
const monObjet = {salut:()=>{console.log("coucou depuis objet")}};
monObjet.salut();

// ? Les paramètres des fonctions

/* 
    Lorsqu'on déclare une fonction, nous pouvons indiquer à celle ci,
    qu'elle doit recevoir des paramètres.
    Ce sont des valeurs qui devront lui être transmise durant son appel.

    Ces paramètres peuvent être utilisé comme variables interne à la fonction.
*/
function bonsoir(nom)
{
    console.log("Bonsoir " + nom);
}
bonsoir("Maurice");
// Si aucun paramètre n'est fourni, il sera considéré comme "undefined"
bonsoir();
// Si trop de paramètre sont fourni, il ignorera ceux en trop.
bonsoir("Maurice", "Pierre");

// On peut ajouter autant de paramètre que voulu, en les séparents d'une virgule
function bonneNuit(nom1, nom2)
{
    // ajouter %c au début d'un console.log permet que le second paramètre soit utilisé comme CSS
    console.log("%cBonne nuit " + nom1+ " et "+nom2,"background: blue; color: yellow;font-size:40px;");
}
// La première valeur, va au premier paramètre, la seconde, au second et ainsi de suite
bonneNuit("Maurice", "Pierre");
/* 
    Il est possible d'ajouter une valeur par défaut à un paramètre.
    Celle ci sera utilisé dans le cas où le paramètre est laissé vide.
*/
function goodBye(nom1, nom2="les autres") 
{
    console.log(`Goodbye ${nom1} et ${nom2}`);
    if(nom1 == undefined)
    {
        console.error("Veuillez donner au moins un nom");
        console.warn("Un second nom serait bien mais pas obligatoire");
    }
}
goodBye("Maurice", "Pierre");
goodBye("Maurice");
goodBye();
/* 
    le rest operator (...nomParamètre) se met sur le paramètre le plus à droite. (le dernier)
    Et va créer un tableau contenant tout les paramètres supplémentaires fournis à la fonction.
*/
function goodMorning(...noms)
{
    // affichage adapté aux tableaux
    console.table(noms);    
    // .toString() ou .join() permettent de transformer un tableau en string
    console.log("Good Morning "+ noms.toString());
    console.log("Good Morning "+ noms.join(" et "));    
}
goodMorning("Maurice", "Pierre", "Charles");

// ? mettre fin à fonction et retourner une valeur.

function insulte(nom)
{
    if(nom === undefined)
    {
        console.error("Veuillez entrer un nom");
        // le mot clef "return" peut être utilisé pour mettre fin à une fonction
        return;
    }
    // Si le mot clef "return" est suivi d'une valeur, celle ci sera renvoyé au code lors de l'appel de la fonction
    return nom + " Le Poltron !";
    console.log("fin fonction");
}
insulte();
const newName = insulte("Bob");
console.log(newName);
console.log(insulte("Bil"));

/* 
    Il est possible d'écrire une fonction fléché sans accolade si elle n'a qu'une seule instruction à réaliser.
    Dans ce cas là, elle possède un "return" implicite. C'est à dire non visible.
*/
const add = (a,b)=>a+b;
console.log(add(7,8));

// ? Fonction récurcive
/* 
    Une fonction récurcive est une fonction qui s'appelle elle-même.
    Il est important dans ce genre de cas, de prévoir une fin à cet enchaînement.
*/
/**
 * Fonction qui affiche un décompte dans la console.
 * @param {number} x Nombre à partir duquel commence le décompte
 * @returns 
 */
function decompte(x)
{
    console.log(x--);
    if(x<0)return;
    decompte(x);
}
decompte(10);

// ? fonctions callback

/* 
    Une fonction callback, est une fonction donné en paramètre d'une autre fonction afin que cette dernière utilise elle même la nouvelle fonction.

    Plein de fonctions JS utilisent des callback.
    Et on peut aussi créer les notres.
*/
const pr = ["Alice", "Ariel", "Mulan", "Belle"];
// La fonction forEach, va appeler la fonction donné en paramètre, en utilisant les différents éléments du tableau en paramètre.
pr.forEach(bonsoir);
/*  
    Ici cela reviendrait à faire: 
    bonsoir("Alice");
    bonsoir("Ariel");
    bonsoir("Mulan");
    bonsoir("Belle");

    On peut aussi directement donné à forEach, une fonction anonyme ou fléché
*/
pr.forEach(function(nom){
    console.log("Bienvenue "+nom);
});
// Il existe plein d'autres fonctions de tableau fonctionnant un peu comme forEach, reduce, map...

/**
 * Appel la fonction en premier paramètre et lui donne comme argument, le nom en second paramètre agrémenté d'un compliment.
 * @param {CallableFunction} maFonction fonction callback
 * @param {string} nom un nom
 */
function compliment(maFonction, nom)
{
    maFonction(nom + " Le magnifique");
}
compliment(bonsoir, "Greg");

//! Lorsqu'on donne une fonction en callback, il ne faut surtout pas mettre les parenthèses. Ce n'est pas un appel que l'on fait, on se contente de donner le nom de notre fonction.
