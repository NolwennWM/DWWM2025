const addParagraph = require('../js/dom');

test('adds a paragraph to the document body', () => {
  // Nettoyer le DOM avant test
  document.body.innerHTML = '';

  addParagraph('Hello world');

  const p = document.querySelector('p');
  expect(p).not.toBeNull();
  expect(p.textContent).toBe('Hello world');
  expect(document.body.contains(p)).toBe(true);
});
