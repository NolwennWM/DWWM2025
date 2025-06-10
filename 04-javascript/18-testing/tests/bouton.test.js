const fs = require('fs');
const path = require('path');

beforeEach(() => {
  const html = fs.readFileSync(path.resolve(__dirname, '../html/bouton.html'), 'utf8');
  document.documentElement.innerHTML = html;
  require('../js/bouton'); // Charger le script pour attacher l'événement
});

test('le texte change quand on clique sur le bouton', () => {
  const button = document.getElementById('btn');
  button.click();

  const text = document.getElementById('text');
  expect(text.textContent).toBe('Bouton cliqué !');
});
