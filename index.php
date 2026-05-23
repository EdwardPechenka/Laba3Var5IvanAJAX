<?php 
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Інтернет-магазин (AJAX)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; line-height: 1.6; }
        form { margin-bottom: 20px; padding: 10px; border: 1px solid #eee; max-width: 500px; }
        label { display: inline-block; width: 150px; font-weight: bold; }
        select, input { padding: 5px; margin-right: 10px; }
        button { padding: 5px 15px; cursor: pointer; }
        #result { margin-top: 30px; padding: 15px; border: 2px dashed #007BFF; background: #f9f9f9; min-height: 50px; }
        ul { list-style-type: square; padding-left: 20px; }
        li { margin-bottom: 5px; }
    </style>
</head>
<body>

    <h1>Панель моніторингу товарів (AJAX)</h1>
    
    <form id="vendorForm">
        <label for="vendor">Виробник:</label>
        <select name="vendor" id="vendor">
            <?php
            $stmt = $pdo->query('SELECT ID_Vendors, v_name FROM vendors');
            while ($row = $stmt->fetch()) { 
                echo "<option value=\"{$row['ID_Vendors']}\">{$row['v_name']}</option>";
            }
            ?>
        </select>
        <button type="submit">Шукати (Text)</button>
    </form>

    <form id="categoryForm">
        <label for="category">Категорія:</label>
        <select name="category" id="category">
            <?php
            $stmt = $pdo->query('SELECT ID_Category, c_name FROM category');
            while ($row = $stmt->fetch()) { 
                echo "<option value=\"{$row['ID_Category']}\">{$row['c_name']}</option>";
            }
            ?>
        </select>
        <button type="submit">Шукати (XML)</button>
    </form>

    <form id="priceForm">
        <label>Ціна від і до:</label>
        <input type="number" id="min_price" value="0" style="width: 80px;" required>
        <input type="number" id="max_price" value="2000" style="width: 80px;" required>
        <button type="submit">Шукати (JSON)</button>
    </form>

    <h2>Результат запиту:</h2>
    <div id="result">Оберіть параметри пошуку та натисніть кнопку...</div>

    <script>
    const resultDiv = document.getElementById('result');

    // =========================================================================
    // 1. Формат ТЕКСТ / HTML (Товари виробника через XMLHttpRequest)
    // =========================================================================
    document.getElementById('vendorForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const vendorId = document.getElementById('vendor').value;
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'vendor_items.php?vendor=' + vendorId, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Сервер віддає готовий HTML шматок тексту, просто вставляємо його
                resultDiv.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });

    // =========================================================================
    // 2. Формат XML (Товари категорії через XMLHttpRequest + парсинг дерева)
    // =========================================================================
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const categoryId = document.getElementById('category').value;
        
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'category_items.php?category=' + categoryId, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const xmlDoc = xhr.responseXML;
                const items = xmlDoc.getElementsByTagName('item');
                
                if (items.length === 0) {
                    resultDiv.innerHTML = '<h3>Товари категорії (формат XML)</h3><p>Товарів у цій категорії немає.</p>';
                    return;
                }
                
                // Будуємо список через JS на основі XML тегів
                let html = '<h3>Товари категорії (формат XML)</h3><ul>';
                for (let i = 0; i < items.length; i++) {
                    let name = items[i].getElementsByTagName('name')[0].textContent;
                    let price = items[i].getElementsByTagName('price')[0].textContent;
                    let quantity = items[i].getElementsByTagName('quantity')[0].textContent;
                    let quality = items[i].getElementsByTagName('quality')[0].textContent;
                    
                    html += `<li><b>${name}</b> — Ціна: ${price} грн, Кількість: ${quantity} шт, Якість: ${quality}/5</li>`;
                }
                html += '</ul>';
                resultDiv.innerHTML = html;
            }
        };
        xhr.send();
    });

    // =========================================================================
    // 3. Формат JSON (Фільтрація за ціною через сучасний Fetch API)
    // =========================================================================
    document.getElementById('priceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const min = document.getElementById('min_price').value;
        const max = document.getElementById('max_price').value;
        
        fetch(`price_items.php?min_price=${min}&max_price=${max}`)
            .then(response => response.json()) // Перетворюємо рядок JSON в масив об'єктів JS
            .then(data => {
                if (data.length === 0) {
                    resultDiv.innerHTML = '<h3>Фільтр за ціною (формат JSON)</h3><p>Товарів у цьому діапазоні не знайдено.</p>';
                    return;
                }
                
                // Рендеримо отримані об'єкти в список
                let html = '<h3>Фільтр за ціною (формат JSON)</h3><ul>';
                data.forEach(row => {
                    html += `<li><b>${row.name}</b> — Ціна: ${row.price} грн, Кількість: ${row.quantity} шт, Якість: ${row.quality}/5</li>`;
                });
                html += '</ul>';
                resultDiv.innerHTML = html;
            })
            .catch(error => {
                resultDiv.innerHTML = '<p style="color:red;">Помилка завантаження JSON даних</p>';
                console.error('Fetch error:', error);
            });
    });
    </script>
</body>
</html>