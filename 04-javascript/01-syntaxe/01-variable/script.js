"use strict";
// Un commentaire sur une ligne
/* 
    Un commentaire 
    sur plusieurs lignes
*/
// ? Déclaration des variables 
/* 
    Il existe trois mots clefs pour déclarer des variables.
    Les noms des variables peuvent contenir n'importe quelle lettre ou chiffre, mais ne peuvent pas commencer par un chiffre
*/
let banane;
// let est le mot clef le plus conseillé pour déclarer une variable.
console.log("Contenu de banane :", banane);
// * la fin d'une instruction en JS, se fait soit par un saut à la ligne, soit par un ";"
var tomate;
// var était l'unique déclaration de variable avant 2016

const cerise = 5;
// const permet de déclarer une variable dont la valeur ne changera pas.
// Tenter de la changer, provoque une erreur. On doit indiquer sa valeur, dès la déclaration.
// cerise = 1;

let a, b, c;
let d = 1, e, f = 12;
// On ne peut pas redéclarer une variable qui a déjà été déclaré.
// let d;
// Pour changer sa valeur, on ne remet pas le mot clef, qui est là juste pour la déclaration.
d = 2;

// ? La portée des variables.

let glet = 1;
var gvar = 1;
// Il est possible de créer des blocs de code avec {}, rarement utile seul, ils le seront ici pour parler de la portée des variables.
{
    let hlet = 2;
    var hvar = 3;
    console.log(glet, gvar, hlet, hvar);
    // Les variables déclarés dans un bloc, sont accessible depuis ce bloc et dans leurs enfants.
    {
        console.log(glet, gvar, hlet, hvar);
    }
}
// Une variable déclaré en "let" dans un bloc, n'existera que dans celui ci. En "var", elle sera accessible partout.
// console.log(glet, gvar, hlet, hvar);
console.log(glet, gvar, hvar);

{
    let glet = 5;
    var gvar = 5;
    console.log("dans le bloc :", glet, gvar);
}
/* 
    Il est possible de redéclarer des variables, si elles sont dans un bloc différent.
    en let ce sera une variable différente, qui n'existera que dans son bloc.
    en var, cela viendra remplacer la variable d'origine.
*/
console.log("hors du bloc :", glet, gvar);