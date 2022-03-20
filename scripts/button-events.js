$(window).on("load", mediaqueryFunction);

const NAVBAR = document.getElementById("navToggle");
var navbarShown = false;

function toggleNav(){

    if (!navbarShown) {
        NAVBAR.style.maxHeight = "3.5rem";
        NAVBAR.style.overflowY = "hidden";
        NAVBAR.style.transition = "max-height 500ms ease-out";
        NAVBAR.scrollTo(0, 0);
        navbarShown = true;
    } else {
        NAVBAR.style.maxHeight = "100vh";
        NAVBAR.style.overflowY = "auto";
        NAVBAR.style.transition = "max-height 500ms ease-in";
        NAVBAR.scrollTo(0, 0);
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
    if (!NAVBAR.contains(e.target) && !document.getElementById('nav-toggle').contains(e.target)){
        navbarShown = false;
        toggleNav();
    }
})

// Almenük nyitása/csukása
var submenuToggled = true;
const SUBMENU = document.getElementById("sub-menu");
const SUBMENUTEXT = document.getElementById("sub-menu-text");
const USERDATASUB = document.getElementById("user-data-content");
const USERLOGINSUB = document.getElementById("login-content");
const SEARCHOPTIONSSUB = document.getElementById("search-options-content");
function toggleSubmenu(menu){
    if(submenuToggled){
        SUBMENU.classList.toggle("d-none");
        SUBMENU.classList.toggle("d-flex");
        submenuToggled = true;
        navbarShown = false;
        toggleNav();
        if(menu !== 0) {
            switch (menu) {
                case 1:
                    SUBMENUTEXT.innerHTML = 'Keresési beállítások';
                    USERDATASUB.style.display = "none";
                    USERLOGINSUB.style.display = "none";
                    SEARCHOPTIONSSUB.style.display = "flex";
                    break;
                case 2:
                    SUBMENUTEXT.innerHTML = 'Felhasználói felület';
                    USERDATASUB.style.display = "flex";
                    USERLOGINSUB.style.display = "none";
                    SEARCHOPTIONSSUB.style.display = "none";
                    break;
                case 3:
                    SUBMENUTEXT.innerHTML = 'Bejelentkezés';
                    USERDATASUB.style.display = "none";
                    USERLOGINSUB.style.display = "flex";
                    SEARCHOPTIONSSUB.style.display = "none";
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

function updateDropdownText(buttonID, buttonArr){
    let tempStr = "", outStr = "";
    if(buttonArr.length > 3 && buttonArr.length < 6){
        outStr = "Több kategória..";
        $('#'+buttonID).removeClass("invalid-data");
    }
    else if(buttonArr.length === 6 ){
        outStr = "Minden kategória";
        $('#'+buttonID).removeClass("invalid-data");
    }
    else if(buttonArr.length < 4 && buttonArr.length > 0){
        for (i=0; i<buttonArr.length; i++){
            tempStr += buttonArr[i] + ", ";
        }
        outStr = tempStr.slice(0, -2);
        $('#'+buttonID).removeClass("invalid-data");
    }
    else if(buttonArr.length === 0){
        outStr = "Nincs kategória :(";
        $('#'+buttonID).addClass("invalid-data");
    }
    document.getElementById(buttonID+'-text').innerHTML = outStr;
}

//
    /* HEADER FORM'S DROPDOWN */
//

var HeaderCardDDSelected = Array(); //Index page -> header card's dropdown selected checkboxes array

$(function () {
    $(".droplist-checkbox").click(function () {
        const clickedParentButton = $(this).parent().prev('button').attr('id');
        switch (clickedParentButton) {
            case "droplist-1-toggle":
                let temp = Array();
                $("input:checkbox[name="+$(this).parent().attr('id')+"]:checked").each(function(){
                    temp.push($(this).val());
                });
                HeaderCardDDSelected = temp;
                if ($(this).hasClass("active-chck")) {
                    $(this).removeClass("active-chck");
                    $("label[for='" + $(this).attr("id") + "']").removeClass("active-checkbox");
                    updateDropdownText(clickedParentButton, HeaderCardDDSelected);
                } else {
                    $(this).addClass("active-chck");
                    $("label[for='" + $(this).attr("id") + "']").addClass("active-checkbox");
                    updateDropdownText(clickedParentButton, HeaderCardDDSelected);
                }
        }
    });
});