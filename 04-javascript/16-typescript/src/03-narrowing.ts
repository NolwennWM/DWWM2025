"use strict";

function birthday(age: number|string): string
{
    // age++;
    // Le narrowing est le fait de resserrer les possibilités
    if(typeof age === "number")
    {
        // Ici age ne peut être qu'un nombre
        age++;
    }else
    {
        // Ici il ne peut être qu'un string
        age = parseInt(age)+1;
    }

    return age+ " ans";
}

function chaussette(droite: string|boolean, gauche: string|number):void
{
    if(droite === gauche)
    {
        // Ici la seule possibilité pour que ce soit égale, c'est que les deux soit de type string
        console.log("Vous avez une paire !", droite, gauche);        
    }
}

function clavier(e: KeyboardEvent|HTMLElement)
{
    if(typeof e === "number")
    {
        // le type "never" indique que selon typescript, il est impossible d'arriver ici.
        console.log(e);        
    }
}
/* 
    "a is Date" indique que la valeur de retour sera un boolean,
    et que ce boolean indiquera si le paramètre "a" est un objet "Date" ou non.
*/
// function isDate(a: any): boolean
function isDate(a: any): a is Date
{
    return a instanceof Date;
}

function check(a: Date|HTMLElement)
{
    if(isDate(a))
    {
        a.getDate();
    }
}