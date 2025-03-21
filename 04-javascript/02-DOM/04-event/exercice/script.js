/*
    Exercice 1 :

    Faire que lors de la selection d'une couleur dans l'input de la div 2
    le texte du bouton change de couleur, 
    et lors de l'appuie sur le bouton, 
    le background de la div change de couleur.
*/

// function Rrgb(){
//     const r = Math.floor(Math.random()*256)
//     const g = Math.floor(Math.random()*256)
//     const b = Math.floor(Math.random()*256)
//         return `rgb(${r},${g},${b})`
//     }

const inputCouleur = document.querySelector('.div2 input') 
const btnCouleur = document.querySelector('.div2 button') 
const div2 = document.querySelector('.div2') 
inputCouleur.addEventListener("input",function(){
    btnCouleur.style.color = inputCouleur.value //`${Rrgb()}`
})
btnCouleur.addEventListener("click", function(){
    div2.style.backgroundColor = inputCouleur.value 
})



/* 
    Exercie 2 :

    Lors du clique sur le bouton de la div 3,
    faire apparaître la modale
    Cette modale doit contenir un élément permettant de la faire disparaître.
*/
const modale = document.querySelector('.modal')
const div3btn = document.querySelector('.div3 button')
const modaleCloseBtn = document.querySelector('.modal button:last-of-type')

div3btn.addEventListener('click', function(){
    modale.classList.remove('hidden')
})

modaleCloseBtn.addEventListener('click',function(){
    modale.classList.add('hidden')
})




/* 
    Exercice 3 :

    Faites que tous nos li dans la nav double de taille lorsque l'on clique dessus.
    puis retournent à leurs tailles d'origine si on clique de nouveau dessus.
*/
const li = document.getElementsByTagName('li')

for (let i=0; i<li.length; i++){
    function liSize (){
        if (li[i].style.transform !== 'scale(2)'){
            li[i].style.transform = 'scale(2)'
        }
        
        else {
            li[i].style.transform = 'scale(1)'
        }
    }
    li[i].addEventListener('click', liSize)
}




/* 
    Exercie 4 :
    
    Utilise les évènements "mouseenter" et "mousemove" pour 
    faire que lorsque l'on passe sur le span du footer, il commence à suivre la souris
    et cela jusqu'à ce que l'on clique, il retournera alors à sa position d'origine.
*/



const spanFooter = document.querySelector('.endOfFile')
// const spanPositionBackup = spanFooter.getBoundingClientRect();
// console.log(spanPositionBackup);



spanFooter.addEventListener('mouseenter', function(){
    spanFooter.style.position = 'fixed'
})

document.addEventListener('mousemove', function(e){
    
    spanFooter.style.left = e.clientX + 'px';
    spanFooter.style.top = e.clientY + 'px';
})

spanFooter.addEventListener('click', function(){
    spanFooter.style.position = 'static'
    
    // spanFooter.style.top = spanPositionBackup.top + "px"
    // spanFooter.style.left = spanPositionBackup.left + "px"
})