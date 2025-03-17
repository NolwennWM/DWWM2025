"use strict";

// log et dir n'ont pas de différence sur firefox. Mais sur chromium, cela change l'affichage: log affiche le html dir affiche l'objet Javascript.
console.log(document.body);
console.dir(document.body);

/* 
    Create element permet de créer uun élément HTML
    textContent permet d'ajouter du texte dans l'élément html
    appenChild ajoute à la fin de l'élément qui le précède l'élément mis en paramètre. (Ici, on ajoute notre span à la fin du body)
*/
const span1 = document.createElement("span");
span1.textContent = "Hello, World!";
console.log(span1);
// On ajoute le span à la fin du body
document.body.appendChild(span1);
//prepend permet de placer un élement HTML au début de son parent. Si on tente d'ajouter un élément HTML qui est déja présent, il sera déplacé.
document.body.prepend(span1);
// append fonctionne comme appendChild mais peu prendre plusieurs paramètres et accepte aussi du texte. (C'est donc plus pratique)
document.body.append(span1, "test");

// innerHTML permet d'ajouter du code HTML dans un élément. C'est donc plus pratique que text Content pour ajouter du code HTML. la différence est que textContent ne permet pas d'ajouter du code HTML. (C'est donc moins pratique). Cependant, innerHTML est plus lourd et peut donc être plus dangereux. (C'est donc à utiliser avec précaution).
// De plus, innerHTML peut se retrouver a lire des balises créés par l'utilisateur (par exemple en commentaire sur un forum) et va les exécuter.

span1.innerHTML= "<b> COUCOU mais en gras </b>";

// ! Pour des raisons de sécurité, si des informations textuelles viennent d'utilisateurs, il faut privilégier textContent.

// affiche le texte avec les indentations et sauts à la ligne
console.log(document.body.textContent);
// affiche toutes les balises et code HTML
console.log(document.body.innerHTML);
// affiche le texte brut, sans indentations ni sauts à la ligne
console.log(document.body.innerText);

// le nettoyage 
document.body.textContent= "";

const h = document.createElement("header");
const m = document.createElement("main");
const f = document.createElement("footer");

h.innerHTML= "<h1>Super Site en JS</h1>";
f.innerHTML= /* html */ `<ul><li>MENU 1</li><li>MENU 2</li><li>MENU 3</li></ul>`;

if(document.body)
    {
        // si le CSS indique des règles pour des éléments qui n'existent pas au chargement de la page, les éléments seront créés quand la page sera chargée et prendront en compte le CSS lors de leur ajout.
        document.body.append(h,m,f);
    }
    
for(let i=0;i<5; i++)
    {
        const p = document.createElement("p");
        p.textContent = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Natus ad provident esse vel, sed eos maiores placeat sint, iusto dolorem vero aliquid animi ab ex, qui nulla. Reiciendis, libero deleniti! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laborum incidunt, animi dicta excepturi cumque eum itaque perferendis maiores, odit eveniet, ad voluptas minus quos a quidem velit magni recusandae ex?" ;
        m.append(p);
    }

const d = document.createElement("div");
m.append(d);
d.innerHTML = /* html */ `<h2>Je garde le stock de bouffe</h2><p>Je vais vous la faire à la cantonnade, dans le genre tragédie grecque, tâchez de vous partager ça au mieux: <br> <b> LA BOUFFE EST INTERDITE EN DEHORS DES HEURES DE REPAS!</b></p><button>J'arrive pour vous botter le train</button><button>J'EN AI RIEN A CARRER!</button>`;
