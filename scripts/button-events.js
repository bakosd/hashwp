$(window).on("load", mediaqueryFunction);

var navbarShown = false;
function toggleNav(){
    if (!navbarShown) {
        document.getElementById("navToggle").style.maxHeight = "3.5rem";
        document.getElementById("navToggle").style.overflowY = "hidden";
        document.getElementById("navToggle").style.transition = "max-height 500ms ease-out";
        navbarShown = true;
    } else {
        document.getElementById("navToggle").style.maxHeight = "100vh";
        document.getElementById("navToggle").style.overflowY = "auto";
        document.getElementById("navToggle").style.transition = "max-height 500ms ease-in";
        navbarShown = false;
    }
}

function mediaqueryFunction(x) {
    if (x.matches) {
        navbarShown = false;
        toggleNav();
    }
}
var x = window.matchMedia("(max-width: 1199px)");
mediaqueryFunction(x); // Call listener function at run time
x.addListener(mediaqueryFunction); // Attach listener function on state changes

// Navon kívülre kattintásnál eltünjön a nav
window.addEventListener('click', function(e){
    if (!document.getElementById('navToggle').contains(e.target) && !document.getElementById('nav-toggle').contains(e.target)){
        navbarShown = false;
        toggleNav();
    }
})

// Almenük nyitása/csukása
var submenuToggled = true;
function toggleSubmenu(menu){
    if(submenuToggled){
        document.getElementById("sub-menu").classList.toggle("d-none");
        document.getElementById("sub-menu").classList.toggle("d-flex");
        submenuToggled = true;
        navbarShown = false;
        toggleNav();
        if(menu !== 0) {
            switch (menu) {
                case 1:
                    document.getElementById('sub-menu-text').innerHTML = 'Keresési beállítások';
                    document.getElementById("user-data-content").style.display = "none";
                    document.getElementById("login-content").style.display = "none";
                    document.getElementById("search-options-content").style.display = "flex";
                    break;
                case 2:
                    document.getElementById('sub-menu-text').innerHTML = 'Felhasználói felület';
                    document.getElementById("user-data-content").style.display = "flex";
                    document.getElementById("login-content").style.display = "none";
                    document.getElementById("search-options-content").style.display = "none";
                    break;
                case 3:
                    document.getElementById('sub-menu-text').innerHTML = 'Bejelentkezés';
                    document.getElementById("user-data-content").style.display = "none";
                    document.getElementById("login-content").style.display = "flex";
                    document.getElementById("search-options-content").style.display = "none";
                    break;
            }
        }
    }
}