// ---------------- EXO 1 --------------------
// 1. Rendre tous les paragraphes du main, invisible (js ou css).
// 2. Ajouter Une observation sur chaque paragraphes.
// 3. Lorsque l'élément est au moins à moitié dans le viewport, le rendre visible.
// 4. Désactiver la détection de l'élément une fois l'action terminé.
// (Bonus). Faire venir le paragraphe depuis le côté.

const paragraphs = Array.from(document.querySelectorAll("main p"));
const fadeinOptions = {
  threshold: 0.5,
};
const fadeinObserver = new IntersectionObserver(showElement, fadeinOptions);

paragraphs.forEach((element) => {
  fadeinObserver.observe(element);
});

function showElement(entries) {
  const entry = entries[0];

  if (entry.isIntersecting) {
    entry.target.classList.add("show");
    fadeinObserver.unobserve(entry.target);
  }
}

//
//     ---------------- EXO 2 ----------------------
//     1. Lorsque le dernier paragraphe est à 200px en dessous du viewport.
//         Créer 10 paragraphes et les ajouter à la suite du main (de simple paragraphes avec du lorem).
//     2. Désactiver la détection du dernier paragraphe.
//     3. Ajouter l'animation de l'exercice 1 aux nouveaux paragraphes.
//     4. Ajouter la détection du dernier paragraphe au nouveau dernier paragraphe qui vient d'être ajouté.
//

const lastParagraphOptions = {
  rootMargin: "200px",
};
const lastParagraphObserver = new IntersectionObserver(lastElement, lastParagraphOptions);
lastParagraphObserver.observe(paragraphs[paragraphs.length - 1]);

function lastElement(entries) {
  const entry = entries[0];

  if (entry.isIntersecting) {
    lastParagraphObserver.unobserve(entry.target);

    for (let i = 0; i < 10; i++) {
      const p = document.createElement("p");
      p.textContent = entry.target.textContent;
      entry.target.parentNode.appendChild(p);
      paragraphs.push(p);
      fadeinObserver.observe(p);
    }

    lastParagraphObserver.observe(paragraphs[paragraphs.length - 1]);
  }
}
