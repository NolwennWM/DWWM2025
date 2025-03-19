// ------------EXO 1 ---------------
// Déplacer la modale dans le body.
const mod = document.querySelector("aside div");
document.body.append(mod);

// ----------- EXO 2 ---------------
// modifier le texte des 3 li du footer, si possible avec une boucle.

const lis = document.querySelectorAll("footer li");
lis.forEach(textChange)

function textChange(el){
    el.textContent = "JS ne me fais pas peur !".toUpperCase()
}

// ------------ EXO 3 --------------
// Remplacer le texte des paragraphes pair.
// réponse 1 :
const paras = document.querySelectorAll(".step:nth-child(even)");
paras.forEach(textChange);
// réponse 2 :
const paras2 = document.querySelectorAll(".step");
for (let i = 0; i<paras2.length; i++) {
    if(i%2 != 0){
        textChange(paras2[i]);
    }
}