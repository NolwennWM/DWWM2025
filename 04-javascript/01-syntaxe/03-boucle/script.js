"use strict";

let a = true;
/* 
    la boucle while() répètera ce qui se trouve entre accolade,
    tant que la condition entre parenthèse est vrai.
*/
while(a)
{
    console.log("Coucou");
    a = Math.random() < 0.5;
}
let b = 0;

while(true)
{
    b++;
    if(b < 10)
    {
        // met fin à l'itération actuelle de la boucle, pour passer à la suivante
        continue;
    }
    if(b === 20)
    {
        // Met fin à la boucle.
        break;
    }
    console.log(`b vaut ${b}`);
}

/* 
    do{}while() va executer ses instructions une première fois.
    Puis ensuite vérifier si il doit boucler ou pas.
*/
do
{
    console.log("do while, b vaut :", b);  
}while(b < 5)

// ? boucle for
/* 
    La boucle for va prendre 3 instructions entre parenthèses, séparés de ";"
    la première se lance avant le début de la boucle.
    la second est une condition vérifiant si la boucle doit continuer.
    la troisième se lancera à la fin de chaque itération
*/
for(let i = 0; i < 10;i++)
{
    console.log("i vaut " + i);
}

// ? for in
const arr = ["pizza", "cannelé", "daifuku"];
const obj = {nom:"Pierre", age: 45, yeux: "vert"};

/* 
    La boucle for in permet de boucler sur un tableau ou un objet.
    Elle fera autant d'itération, qu'il y a d'élément dans le tableau ou l'objet.
    à chaque itération, dans le cas d'un objet, la variable contiendra le nom d'une propriété.
    et dans le cas d'un tableau, l'index suivant. (0,1,2...)
*/
for(let index in arr)
{
    console.log("index vaut ", index);
    console.log(index, "->", arr[index]);    
}
for(let prop in obj)
{
    console.log("prop vaut ", prop);
    console.log(prop, " -> ", obj[prop]);    
}

// ? for of
/* 
    Il ne fonctionne que sur les tableaux et non sur les objets.
    Il va parcourir le tableau et donner à chaque itération, la valeur suivante.
*/
for(let valeur of arr)
{
    console.log("valeur vaut ", valeur);    
}