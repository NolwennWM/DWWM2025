"use strict";

// ? Alias 
/* 
    Les alias permettent de créer nos propres types afin de pouvoir les réutiliser à plusieurs endroits.
    Très pratique quand notre type est un long objet contenant des tas de propriété
*/
type Fruit = {nom: string, couleur: string};

let f: Fruit = {nom: "Pomme", couleur: "rouge"};
let aF: Fruit[] = [f, {nom: "Banane", couleur: "Jaune"}];

type Age = number|string;
// On peut utiliser un alias dans un autre.
type Person = {nom: string, age: Age};

let p: Person = {nom: "Maurice", age: 54};

// Ici j'indique que le type "Name" a le même type que la propriété "nom" dans "Fruit". 
type Name = Fruit["nom"];

let n: Name = "George";

// Ici j'indique que le type Full n'accepte que des string qui sont les noms des propriétés de Person. (age ou nom) 
type Full = keyof Person;

let fp: Full = "nom";

// La dernière possibilité est de créer un type à partir d'un élément déjà existant :
let objet = {vieux: true, nom: "chaise", age: 78};
type Item = typeof objet;

// ? Generics

function useless(arg: any):any
{
    return arg;
}

let machine = useless("Salut");
/* 
    Par défaut, typescript ne connaît pas la logique interne d'une fonction.
    Si on lui dit que la valeur de retour est "any", alors ça sera "any" et rien d'autre.

    Mais on peut lui indiquer grâce aux generics que la valeur de l'argument est le même que celui de la valeur de retour.
*/
function usefull<MonType>(arg: MonType): MonType
{
    return arg;
}
let machine2 = usefull("Salut");
let machine3 = usefull(12);

function lastOf<TypeArr>(tab: TypeArr[]): TypeArr|undefined
{
    return tab.at(-1);
}
let last = lastOf([1,2,3,4,5]);

// On peut préciser que notre type possède certaines propriétés avec "extends"
function logSize<Type2 extends {length: number}>(arg:Type2):Type2
{
    console.log(arg.length);
    return arg;
}
// Ici ma fonction n'accepte que des éléments qui ont une propriété "length"
logSize([45]);
logSize("chaussette");
// logSize(100);