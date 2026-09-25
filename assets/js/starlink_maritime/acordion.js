var acc = document.getElementsByClassName("acordion-item");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function () {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    var svg = this.querySelector("svg");
    if (svg) {
      svg.classList.toggle("rotate");
    }
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}
document.querySelectorAll('.hover-section').forEach(function (section) {

  section.addEventListener('click', function () {
    if (window.innerWidth < 1024) {
      if (this.style.transform === 'translateY(600px)') {
        this.style.transform = 'translateY(0)';
      } else {
        this.style.transform = 'translateY(600px)';
      }
    }
  });
});

document.querySelectorAll('.directions-wrapper .item').forEach(function (section) {
  console.log(true)
  section.addEventListener('click', function (event) {
    if (window.innerWidth < 1024) {
      const hoverSection = section.querySelector('.hover-section');

      if (hoverSection) {
        if (hoverSection.style.transform === 'translateY(600px)') {
          hoverSection.style.transform = 'translateY(0)';
          console.log(hoverSection);

        } else {
          hoverSection.style.transform = 'translateY(600px)';
        }
      }
    }
  });
});

document.querySelectorAll('.menu-items').forEach(item => {
  item.addEventListener('click', function () {
    document.querySelector('.big_menu_block').classList.toggle('active');
    document.querySelector('.header').classList.toggle('header-2');
    document.querySelector('.iec_header_wrapper .iec_header_right').classList.toggle('header-2');
  });
});

let hoverActive = false;


//////////////////////////


let hoverActive2 = false;


document.querySelector('.lang').addEventListener('click', function () {
  const menu = document.querySelector('.language-menu');
  menu.classList.toggle('visible');

  // Обертання стрілки
  this.classList.toggle('open');
});

// Оновлення поточної мови при виборі
document.querySelectorAll('.language-menu a').forEach(function (link) {
  link.addEventListener('click', function (event) {
    event.preventDefault(); // Щоб не переходити відразу на іншу сторінку
    const selectedLang = this.textContent.trim();
    document.querySelector('.current-lang').textContent = selectedLang;

    // Зробити перенаправлення на сторінку мови після оновлення тексту (при потребі)
    window.location.href = this.href;
  });
});

