"use strict";
class Truc {
    prenom = "Maurice";
    nom = "Dupont";
    age = 54;
}
const t = new Truc();
t.prenom;
// t.nom;
// t.age;
class Machin extends Truc {
    constructor() {
        /*
            Les propriétés "protected" sont au même titre que les "private" inutilisable en dehors de la classe.
            Mais comme les "public" sont héritées.
        */
        super();
        this.prenom;
        this.nom;
        // this.age;
    }
    // il est possible d'indiquer le type de "this", cela n'est pas considéré comme un paramètre de la méthode.
    faireUnTruc() {
        console.log(this);
    }
}
class Collection {
    items;
    /*
        Indiquer le type de propriété directement en paramètre du constructor
        Est un raccourci pour lui indiquer de sauvegarder ce paramètre en tant que propriété de la class.
    */
    constructor(items) {
        this.items = items;
    }
    addOne(arg) {
        this.items.push(arg);
        return this;
    }
}
const c = new Collection([42, 13, 89, 32]);
c.addOne(12).addOne(90).addOne(67);
// c.addOne(90);
// c.addOne(67);
class Triangle {
    c1 = 5;
    c2 = 9;
    c3 = 2;
}
class Rectangle {
    c1 = 12;
    c2 = 24;
}
function getC1(arg) {
    return arg.c1;
}
/*
    Lorsque TS vérifie que le type du paramètre d'une fonction correspond.
    Il ne vérifi pas le nom de celui ci.
    Il vérifi si les propriétés de l'élément sont bien présents
*/
getC1(new Rectangle());
getC1(new Triangle());
getC1({ c1: 34, c2: 43 });
/*
    Une classe abstraite ne peut pas être instancié.
    Elle a pour rôle uniquement d'être hérité à d'autres classes
*/
class Polygone {
    sides = {};
    countSide() {
        return Object.keys(this.sides).length;
    }
}
// new Polygone();
class Carre extends Polygone {
    constructor(c) {
        super();
        this.sides.c = c;
    }
    /*
        Une méthode abstraite, indique les paramètres et valeur de retour mais pas le corps de la fonction.
        Ce sera au rôle des héritiés de déclarer comment fonctionne la méthode.

        Dans notre exemple on indique que tous nos polygones ont une méthode "surface" qui retourne un nombre.
        Mais le calcul de cette surface diffère entre un Carré, un Triangle...
    */
    surface() {
        return this.sides.c * this.sides.c;
    }
}
