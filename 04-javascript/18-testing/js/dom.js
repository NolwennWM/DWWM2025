// dom.js
function addParagraph(text) {
  const p = document.createElement('p');
  p.textContent = text;
  document.body.appendChild(p);
}

module.exports = addParagraph;
