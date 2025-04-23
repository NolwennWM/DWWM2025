"use strict";
let f = { nom: "Pomme", couleur: "rouge" };
let aF = [f, { nom: "Banane", couleur: "Jaune" }];
let p = { nom: "Maurice", age: 54 };
let n = "George";
let fp = "nom";
// La dernière possibilité est de créer un type à partir d'un élément déjà existant :
let objet = { vieux: true, nom: "chaise", age: 78 };
// ? Generics
function useless(arg) {
    return arg;
}
let machine = useless("Salut");
/*
    Par défaut, typescript ne connaît pas la logique interne d'une fonction.
    Si on lui dit que la valeur de retour est "any", alors ça sera "any" et rien d'autre.

    Mais on peut lui indiquer grâce aux generics que la valeur de l'argument est le même que celui de la valeur de retour.
*/
function usefull(arg) {
    return arg;
}
let machine2 = usefull("Salut");
let machine3 = usefull(12);
function lastOf(tab) {
    return tab.at(-1);
}
let last = lastOf([1, 2, 3, 4, 5]);
// On peut préciser que notre type possède certaines propriétés avec "extends"
function logSize(arg) {
    console.log(arg.length);
    return arg;
}
// Ici ma fonction n'accepte que des éléments qui ont une propriété "length"
logSize([45]);
logSize("chaussette");
