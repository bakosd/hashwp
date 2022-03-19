$(window).on("load", mediaqueryFunction);

var navbarShown = false;
function toggleNav(){
    if (!navbarShown) {
        document.getElementById("navToggle").style.maxHeight = "3.5rem";
        document.getElementById("navToggle").style.overflowY = "hidden";
        document.getElementById("navToggle").style.transition = "max-height 500ms ease-out";
        document.getElementById("navToggle").scrollTo(0, 0);
        navbarShown = true;
    } else {
        document.getElementById("navToggle").style.maxHeight = "100vh";
        document.getElementById("navToggle").style.overflowY = "auto";
        document.getElementById("navToggle").style.transition = "max-height 500ms ease-in";
        document.getElementById("navToggle").scrollTo(0, 0);
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

function dropdownList(dropID, buttonID){
    document.getElementById(buttonID).classList.toggle("droplist-btn-clear-bottom");
    document.getElementById(buttonID).children[1].classList.toggle("fa-angle-up");
    document.getElementById(dropID).classList.toggle("d-none");
}
function updateDropdownText(buttonID, buttonTextID, buttonCounter, buttonArr, buttonArrStr){
    let tempStr = "", outStr = "";
    if(buttonCounter > 3 && buttonCounter < 6){
        outStr = "Több kategória..";
        $(buttonID).removeClass("invalid-data");
    }
    else if(buttonCounter === 6 ){
        outStr = "Minden kategória";
        $(buttonID).removeClass("invalid-data");
    }
    else if(buttonCounter < 4 && buttonCounter > 0){
        for (let key in buttonArr) {
            if(buttonArr[key] === 1){
                tempStr += buttonArrStr[key] + ", ";
            }
        }
        outStr = tempStr.slice(0, -2);
        $(buttonID).removeClass("invalid-data");
    }
    else if(buttonCounter === 0){
        outStr = "Nincs kategória :(";
        $(buttonID).addClass("invalid-data");
    }
    document.getElementById(buttonTextID).innerHTML = outStr;
}
//
    /* HEADER FORM'S DROPDOWN */
//
var selected = {varosi:1, elektromos:1, szedan:1, terepjaro:1, limuzin:1, kabrio:1};
var selectedStr = {varosi:"Városi", elektromos:"Elektromos", szedan:"Szedán", terepjaro:"Terepjáró", limuzin:"Limuzin", kabrio:"Kabrió"};
var count = 6;
$(function() {
    $(".droplist-checkbox").click(function() {
        if($(this).hasClass("active-chck")) {
            $(this).removeClass("active-chck");
            $("label[for='"+$(this).attr("id")+"']").removeClass("active-checkbox");
            selected[$(this).attr("name")] = 0;
            count--;
            updateDropdownText('#droplist-toggle', 'droplist-toggle-text', count, selected, selectedStr);
        }
        else{
            $(this).addClass("active-chck");
            $("label[for='"+$(this).attr("id")+"']").addClass("active-checkbox");
            selected[$(this).attr("name")] = 1;
            count++;
            updateDropdownText('#droplist-toggle', 'droplist-toggle-text', count, selected, selectedStr);
        }
    });
});