"use strict";

type Chaussette = string;
// type Chaussette = string|number;
/* 
    L'interface est à moitié une classe abstraite et à moitié un type.
    Elle va servir de plan de construction à une classe.
*/
interface Point
{
    x: number;
    y: number;
    get(): number;
}
// On peut ajouter de nouveaux éléments à une interface.
interface Point
{
    z: number;
}

interface Document
{
    chaussette: string;
}
document.chaussette
// Pour utiliser une interface, on utilisera "implements"
class Point3D implements Point
{
    x = 0;
    y = 1;
    z = 2;
    get()
    {
        return this.x;
    }
}
function show(p: Point){}
show(new Point3D());
