function calculateMaxHeight(element) {
    const subMenu = element.querySelector('.sub-menu');
    const height = Array.from(subMenu.children).reduce((acc, child) => acc + child.offsetHeight, 0);
    subMenu.style.maxHeight = height + 'px';
}

let iocnLinks = document.querySelectorAll(".iocn-link");
for (var i = 0; i < iocnLinks.length; i++) {
    iocnLinks[i].addEventListener("click", (e) => {
        let linkParent = e.currentTarget.parentElement; // Menggunakan parentElement untuk mendapatkan li
        if (linkParent.classList.contains("showMenu")) {
            linkParent.classList.remove("showMenu");
        } else {
            removeShowMenuFromAll(); // Menghilangkan showMenu dari semua elemen li
            linkParent.classList.add("showMenu");
        }
    });
}

let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        e.stopPropagation(); // Menghentikan penyebaran ke parent, hindari memicu klik iocn-link
        let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
        if (arrowParent.classList.contains("showMenu")) {
            arrowParent.classList.remove("showMenu");
        } else {
            removeShowMenuFromAll(); // Menghilangkan showMenu dari semua elemen li
            arrowParent.classList.add("showMenu");
        }
    });
}

function removeShowMenuFromAll() {
    let allLiElements = document.querySelectorAll(".nav-links > li");
    for (let i = 0; i < allLiElements.length; i++) {
        allLiElements[i].classList.remove("showMenu");
    }
}

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
console.log(sidebarBtn);
sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

