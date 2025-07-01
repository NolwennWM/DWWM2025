# 🧪 Exercise – Create a rendering engine with buffer in PHP

## 🎯 Objective

Set up a mini PHP templating system using **output buffering** to separate content from layout and display **simulated dynamic data**.

---

## 📋 Instructions

1. **Create the following files**:

   - `index.php`: the main entry file  
   - `page.php`: contains the specific content to display  
   - `layout.php`: the general HTML layout  
   - `db.php`: database connection file  

2. In `db.php`, create a product array:

   Connect to the "bière" database.

3. In `index.php`:

   - Initialize the page title in a variable  
   - Start the buffer (`ob_start()`)  
   - Include `page.php`  
   - Capture the buffer into `$content` with `ob_get_clean()`  
   - Display `layout.php`

4. In `page.php`:

   - Include `db.php`  
   - Retrieve articles from the database  
   - Loop through the products and display their name and price in an HTML list  

5. In `layout.php`:

   - Display a basic HTML layout (`<!DOCTYPE html>`, `<head>`, `<body>`, etc.)  
   - Display the page title  
   - Dynamically insert the content with `<?= $content ?>`

---

## ✅ Expected result

The user accesses `index.php` and sees an HTML page with a list of products displayed dynamically from the PHP array.

---

## 🧠 Bonus (optional)

- Integrate Bootstrap to improve styling  
- Add a condition in `page.php` if no products are found  
- Create a second page (e.g., `contact.php`) and allow page selection via `index.php?page=...`
