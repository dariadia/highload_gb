<?php

include_once "RedisService.php";
$books = MySqlDB::getInstance()->query('SELECT * FROM goods');

?>

<div class="books">
<?php foreach ($books as $book): ?>
  <div class="book" data-id="<?= $book["id"] ?>"><?= $book["title"] ?></div>
<?php endforeach; ?>
</div>
<div class="col">
  <img src="" alt="" class="book-image">
  <div class="book-desc"></div>
  <span class="book-price"></span> руб.
  <button class="btn-buy" type="button">Купить</button>
</div>

<script>
  const column = document.querySelector('.col');
  const books = document.querySelectorAll('.book');
  books.forEach(el => {
    el.addEventListener('mouseover', e => {
      const id = el.dataset.id;
      let xhr = new XMLHttpRequest();
      xhr.open('GET', '/ajax.php?id=' + id);
      xhr.send();
      xhr.onload = function() {
      if (xhr.status !== 200) {
          alert(`Error ${xhr.status}: ${xhr.statusText}`);
      } else {
        const response = JSON.parse(xhr.response);
        if (~response.id) {
        modal.querySelector('img').src = '/images/' + response.image;
        modal.querySelector('.book-desc').textContent = response.description;
        modal.querySelector('.book-price').textContent = response.price;
        modal.classList.add('active');
        }
      }
      };
    });
  });
</script>
