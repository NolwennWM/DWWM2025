"use strict";

const ps = document.querySelectorAll('main p');
const obs = new IntersectionObserver(showPara, {threshold: 0.5});

// J'observe chacun de mes éléments un à un.
ps.forEach(p=>obs.observe(p));

function showPara(entries){
    entries.forEach(reveal)
}
function reveal(entry){
    if(entry.isIntersecting){
        entry.target.style.opacity = "1"
        // entry.target.style.transform = "translateX(0)"
        entry.target.classList.add("rotate-in-hor")
        obs.unobserve(entry.target);
    }
}
// Version raccourci
// const obs = new IntersectionObserver(entries=>entries.forEach(entry=>{
//     if(entry.isIntersecting){
//         entry.target.style.opacity = "1"
//         obs.unobserve(entry.target);
//     }
// })
// , {threshold: 0.5});
// ps.forEach(p=>obs.observe(p));

// EXO 2
const lastP = document.querySelector('main p:last-child');
const obsLast = new IntersectionObserver(addMore, {rootMargin: "200px"});
const m = document.querySelector('main');
obsLast.observe(lastP);

function addMore(entries){
    let ent = entries[0];
    if(ent.isIntersecting){
        let p;
        for (let i = 0; i < 10; i++) {
            p = document.createElement("p");
            p.textContent = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis mollitia aspernatur nesciunt ipsam quibusdam praesentium corrupti libero, reprehenderit repellendus omnis consequuntur necessitatibus soluta dolorem, sequi eos ratione porro, quasi repudiandae.Blanditiis saepe ratione cumque asperiores provident perspiciatis aliquid, exercitationem adipisci! Distinctio labore excepturi illo! Distinctio fugiat repudiandae iste tempore ducimus sed veritatis a eum expedita fuga. Quidem, officia fuga? Soluta.Expedita impedit neque odit accusantium sunt cum, numquam esse quo deleniti explicabo ipsum ducimus eveniet, eos exercitationem amet temporibus aliquid suscipit maiores fugiat. Nulla nam ullam voluptate deserunt ipsum autem.Architecto corrupti earum quam quo illum deserunt dignissimos ex, laudantium iusto! Quae soluta voluptatibus laboriosam aut reiciendis, laudantium ut eum, officiis vitae excepturi cupiditate voluptas consequatur eveniet deleniti at eos.Labore, animi amet impedit sunt recusandae fugiat saepe. Officiis, vitae? Non rem illo odit cum ad officia est consequatur eos. Neque consequuntur laborum magni facilis alias quos, impedit ducimus sit?"          
            m.append(p);
            obs.observe(p);
        }
        obsLast.unobserve(lastP);
        obsLast.observe(p)
    }
}