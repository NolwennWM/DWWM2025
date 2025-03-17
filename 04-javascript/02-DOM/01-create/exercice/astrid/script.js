// EXERCICE

const h2 = document.createElement("h2");
h2.innerHTML = /* html */ `Santé !`;
const p = document.createElement("p");
p.innerHTML = /*html*/ `Mangez 5 fruits et légumes par jour, les produits laitiers sont nos amis pour la vie, ne mangez ni trop gras, ni trop sucré, ni trop salé,l'abus d'alcool est dangereux pour la santé`;
const button1 = document.createElement("button");
button1.innerHTML = /*html*/ `Tchin Tchin!`;
const button2 = document.createElement("button");
button2.innerHTML = /*html*/ `Le gras c'est la vie!`



if (document.body)
{
    const D = document.createElement("div");
    D.append(h2, p, button1, button2)
    document.body.append(D)
}
