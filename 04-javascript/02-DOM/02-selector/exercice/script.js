// ------------EXO 1 ---------------
// Déplacer la modale dans le body. Celle ci est déjà présente, mais le CSS la cache. Il faudra la déplacer sans modifier le CSS

// ----------- EXO 2 ---------------
// modifier le texte des 3 li du footer, si possible avec une boucle.


// ------------ EXO 3 --------------
// Remplacer le texte des paragraphes pair.

// EXO 1

const div = document.getElementsByTagName('div');
// ! ATTENTION, la variable header est déclaré dans le script du cours
header.appendChild(div[0]);
// Le rang est obligatoire a cause du sélecteur getElementsByTagName

// EXO 2
// ! la variable lis est déclaré dans le cours
for (let i = 0; i < lis.length; i++) {
    lis[i].textContent = `Nouveau Menu ${i + 1}`;
}

// EXO 3

const peven = document.querySelectorAll('p:nth-of-type(even)');
for (let i = 0; i < peven.length; i++) {
    peven[i].textContent = `Je suis un nouveau texte`;
}