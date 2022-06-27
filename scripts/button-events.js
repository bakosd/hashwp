$(document).ready(function (){
    NAVBAR = document.getElementById("navToggle");
    navbarShown = false;
    $('#nav-toggle').on('click', function (){toggleNav();});
});

$(document).ready(mediaqueryFunction);

var NAVBAR = document.getElementById("navToggle");
var navbarShown = false;

function toggleNav() {
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
window.addEventListener('click', function (e) {
    if (!NAVBAR.contains(e.target) && !document.getElementById('nav-toggle').contains(e.target)) {
        navbarShown = false;
        toggleNav();
    }
})

// Almenük nyitása/csukása
var path = window.location.pathname;
var page = path.split("/").pop();
var submenuToggled = true;
const SUBMENU = document.getElementById("sub-menu");
const SUBMENUTEXT = document.getElementById("sub-menu-text");
const USERDATASUB = document.getElementById("user-data-content");
const USERLOGINSUB = document.getElementById("login-content");
var SEARCHOPTIONSSUB = null;
if(page == "car.php" || page == "cars.php") {
    SEARCHOPTIONSSUB = document.getElementById("search-options-content");
}

function toggleSubmenu(menu) {
    if (submenuToggled) {
        SUBMENU.classList.toggle("d-none");
        SUBMENU.classList.toggle("d-flex");
        submenuToggled = true;
        navbarShown = false;
        toggleNav();
        if (menu !== 0) {
            switch (menu) {
                case 1:
                    SUBMENUTEXT.innerHTML = 'Keresési beállítások';
                    if(USERDATASUB !=null)
                        USERDATASUB.style.display = "none";
                    if(USERLOGINSUB !=null)
                        USERLOGINSUB.style.display = "none";
                    if(SEARCHOPTIONSSUB !=null)
                        SEARCHOPTIONSSUB.style.display = "flex";
                    break;
                case 2:
                    SUBMENUTEXT.innerHTML = 'Felhasználói felület';
                    if(USERDATASUB !=null)
                        USERDATASUB.style.display = "flex";
                    if(USERLOGINSUB !=null)
                        USERLOGINSUB.style.display = "none";
                    if(SEARCHOPTIONSSUB !=null)
                        SEARCHOPTIONSSUB.style.display = "none";
                    break;
                case 3:
                    SUBMENUTEXT.innerHTML = 'Bejelentkezés';
                    if(USERDATASUB !=null)
                        USERDATASUB.style.display = "none";
                    if(USERLOGINSUB !=null)
                        USERLOGINSUB.style.display = "flex";
                    if(SEARCHOPTIONSSUB !=null)
                        SEARCHOPTIONSSUB.style.display = "none";
                    break;
            }
        }
    }
}

//
/* CUSTOM DROPDOWN LIST */
//
var DroppDownMainArray = Array(); //Mutli dimensional array for droppdown-s checkbox list

function dropdownList(dropID, buttonID) {
    document.getElementById(buttonID).classList.toggle("droplist-btn-clear-bottom");
    document.getElementById(buttonID).children[1].classList.toggle("fa-angle-up");
    document.getElementById(dropID).classList.toggle("d-none");
}

function updateDropdownText(buttonID, buttonArr) {
    let tempStr = "", outStr = "";
    if (buttonArr.length > 0) {
        for (let i = 0; i < buttonArr.length; i++) {
            tempStr += buttonArr[i] + ", ";
        }
        outStr = tempStr.slice(0, -2);
        //$('#' + buttonID).removeClass("invalid-data");
    } else if (buttonArr.length === 0) {
        outStr = "Nincs kiválasztott";
        //$('#' + buttonID).addClass("invalid-data");
    }
    if (outStr.length > 35) {
        outStr = outStr.substr(0, 32) + ".."; //TO LIMIT STRING WIDTH
    }
    document.getElementById(buttonID + '-text').innerHTML = outStr;
}


function dropDownAbsolute() {
    $(".droplist-button").click(function () {
        let tempWidth = parseInt($(this).width()) + parseInt($(this).css('paddingLeft').slice(0, -2)) + parseInt($(this).css('paddingRight').slice(0, -2));
        $(this).next().css("cssText", "width: " + tempWidth + "px !important; ");
        DroppDownMainArray[$(this).attr('id')] = Array();

        $(".droplist-checkbox").click(function () {
            const clickedParentButton = $(this).parent().prev('button').attr('id');
            let temp = Array();
            $("input:checkbox[data-dl=" + $(this).parent().attr('id') + "]:checked").each(function () {
                temp.push($(this).val());
            });
            DroppDownMainArray[clickedParentButton] = temp;
            if ($(this).hasClass("active-chck")) {
                $(this).removeClass("active-chck");
                $("label[for='" + $(this).attr("id") + "']").removeClass("active-checkbox");
                updateDropdownText(clickedParentButton, DroppDownMainArray[clickedParentButton]);
            } else {
                $(this).addClass("active-chck");
                $("label[for='" + $(this).attr("id") + "']").addClass("active-checkbox");
                updateDropdownText(clickedParentButton, DroppDownMainArray[clickedParentButton]);
            }
            if (!$(this).parent().hasClass("droplist-multiselect")) { // IF THE CHECKLIST IS NOT MULTISELECT
                let parent = $(this).attr('id');
                let parentParent = $(this).parent().attr('id');
                $('#' + parentParent + ' .droplist-checkbox').each(function () {
                    if ($(this).attr('id') !== parent) {
                        if (DroppDownMainArray[clickedParentButton].length > 0) {
                            $(this).prop("disabled", true);
                        } else {
                            $(this).prop("disabled", false);
                        }
                    }
                });
            }
        });
    });
    return false;
}
$(document).ready(dropDownAbsolute());

var darkModeState = localStorage.getItem('darkModeState');
const darkModeToggle = document.getElementById('theme-changer');

const enableDarkMode = () => {
    document.documentElement.setAttribute('data-theme', 'dark');
    animation();
    darkModeToggle.children.item(0).classList.toggle('fa-sun')
};
const disableDarkMode = () => {

    document.documentElement.setAttribute('data-theme', 'light');
    animation();
    darkModeToggle.children.item(0).classList.toggle('fa-sun')
}

//Changing the theme if enabled on page-load
window.onload = () => {
    if (darkModeState === "enabled") {
        document.documentElement.setAttribute('data-theme', 'dark');
        darkModeToggle.children.item(0).classList.toggle('fa-sun')
    }
}

//EventHandler for clicking the theme-changer button
darkModeToggle.addEventListener('click', () => {
    darkModeState = localStorage.getItem('darkModeState');
    if(darkModeState === "enabled") {
        disableDarkMode();
        localStorage.setItem('darkModeState', null);
    }
    else
    {
        enableDarkMode();
        localStorage.setItem('darkModeState', "enabled");
    }
});


//Animation transition on theme-change
let animation = () => {
    document.documentElement.classList.add('transition');
    window.setTimeout(() => {
        document.documentElement.classList.remove('transition');
    }, 1000)
};

function pushButtonsInit(){
    try {
        const droppushBtn = document.querySelectorAll('[data-droppush-btn]');
        if(droppushBtn != null)
            droppushBtn.forEach((button) => {
                button.addEventListener('click', () => {
                    let childContent = button.parentElement.querySelector('[data-droppush-content]');
                    let thisArrow = button.querySelector('i');
                    thisArrow.classList.toggle('fa-angle-up');
                    childContent.classList.toggle('d-none');
                });
            });

    }catch (e){
        //console.log(e);
    }
}
$(document).ready(pushButtonsInit);


$(document).ready(function () {
   const forgotBtn = $('#forgot-password');
   forgotBtn.on('click', function (e) {
       e.preventDefault();
      forgotBtn.after('<div class="px-1 py-1"><label for="user-email-recovery" class="user-select-none">E-mail cím</label><div class="login-input input-with-icon d-flex align-items-center"><i class="px-2 fa-solid fa-key"></i> <input type="email" id="email-recovery" name="email-recovery" form="recovery_form" maxlength="120" minlength="5" placeholder="E-mail cím" autocomplete="false"></div></div><input class="button w-75 mx-auto" type="submit" id="recovery-submit" form="recovery_form" name="recovery-submit" value="Kód küldése">');
      forgotBtn.off('click');
   });

   const recoveryForm = $('#recovery_form');
    recoveryForm.on('submit', function (e){
        e.preventDefault();
        let email = $('#email-recovery').val();
        if(email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
            $(this).load('recovery.php',{
                email: email
            });
        }
   })
});