let megaMenuTimeout;

// Hiện mega menu khi hover
function showMegaMenu(menuId) {
    clearTimeout(megaMenuTimeout);
    document.getElementById(menuId).style.display = "block";
}

// Ẩn mega menu khi rời chuột (chờ 300ms để người dùng chuyển vùng)
function hideMegaMenu(menuId) {
    megaMenuTimeout = setTimeout(() => {
        document.getElementById(menuId).style.display = "none";
    }, 300);
}

document.addEventListener("DOMContentLoaded", function () {
    // xử lý cho "Xe của bạn"
    const megaMenu = document.getElementById("megaMenu");
    const megaMenuButton = document.getElementById("megaMenuButton");

    if (megaMenu && megaMenuButton) {
        megaMenuButton.addEventListener("mouseover", function () {
            showMegaMenu("megaMenu");
        });
        megaMenuButton.addEventListener("mouseleave", function () {
            hideMegaMenu("megaMenu");
        });

        megaMenu.addEventListener("mouseover", function () {
            showMegaMenu("megaMenu");
        });
        megaMenu.addEventListener("mouseleave", function () {
            hideMegaMenu("megaMenu");
        });

        // Xử lý click trên nút "Xe của bạn"
        megaMenuButton.addEventListener("click", function (e) {
            window.location.href = megaMenuButton.getAttribute("href");
        });
    }

    // xử lý cho "Phụ tùng"
    const megaMenuPhutung = document.getElementById("megaMenuPhutung");
    const phutungMenuBtn = document.getElementById("phutungMegaMenu");

    if (megaMenuPhutung && phutungMenuBtn) {
        phutungMenuBtn.addEventListener("mouseover", function () {
            showMegaMenu("megaMenuPhutung");
        });
        phutungMenuBtn.addEventListener("mouseleave", function () {
            hideMegaMenu("megaMenuPhutung");
        });

        megaMenuPhutung.addEventListener("mouseover", function () {
            showMegaMenu("megaMenuPhutung");
        });
        megaMenuPhutung.addEventListener("mouseleave", function () {
            hideMegaMenu("megaMenuPhutung");
        });

        // Xử lý click trên nút "Phụ tùng"
        phutungMenuBtn.addEventListener("click", function (e) {
            window.location.href = phutungMenuBtn.getAttribute("href");
        });
    }
});