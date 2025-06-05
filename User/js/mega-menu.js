let megaMenuTimeout;

function showMegaMenu() {
    clearTimeout(megaMenuTimeout);
    document.getElementById("megaMenu").style.display = "block";
}

function hideMegaMenu() {
    megaMenuTimeout = setTimeout(() => {
        document.getElementById("megaMenu").style.display = "none";
    }, 300);
}

document.addEventListener("DOMContentLoaded", function () {
    const megaMenu = document.getElementById("megaMenu");
    if (megaMenu) {
        megaMenu.addEventListener("mouseover", () => {
            clearTimeout(megaMenuTimeout);
            megaMenu.style.display = "block";
        });

        megaMenu.addEventListener("mouseleave", () => {
            hideMegaMenu();
        });
    }
});
