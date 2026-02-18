//******************************
// ========================
//  variables
// ========================
//******************************
 
const menuIcon = document.getElementById("menuIcon");
const closeBtnMenu = document.querySelector(".closeBtnMenu")
const navLink = document.querySelector(".nav-links")
const dropdowns = document.querySelectorAll(".dropdown");
const menuBtnsSticky=document.querySelector(".menuBtnsSticky")
const menuBtnsOtherMenu=document.querySelector(".menuBtnsOtherMenu")



//******************************
// ========================
//  main page
// ========================
//******************************

//open the menu
  menuIcon.addEventListener("click", function () {
    navLink.classList.add("active");
    menuIcon.style.display = "none";
    
    // Affiche les boutons selon ce qui existe
    if (menuBtnsSticky) {
        menuBtnsSticky.classList.add("active");
    }
    if (menuBtnsOtherMenu) {
        menuBtnsOtherMenu.classList.add("active");
    }
});

//close the menu
closeBtnMenu.addEventListener("click", function () {
    navLink.classList.remove("active");
    menuIcon.style.display = "block";
    
    if (menuBtnsSticky) {
        menuBtnsSticky.classList.remove("active");
    }
    if (menuBtnsOtherMenu) {
        menuBtnsOtherMenu.classList.remove("active");
    }
});

// menu change when dropp down on main page 

// 
for(let dropdown of dropdowns){
    const Mainlink = dropdown.querySelector("a")

Mainlink.addEventListener("click", function(e){
    if(navLink.classList.contains("active")){
         e.preventDefault();
         dropdown.classList.toggle("open");

    }

    })


    for(let dropdown of dropdowns){
    // Select the main link of each dropdown
    const Mainlink = dropdown.querySelector("a")

    //  on the main link clic
    Mainlink.addEventListener("click", function(e){
        // if the navigation menu is open -> has "active" class
        if(navLink.classList.contains("active")){
            // cancel the prevent
            e.preventDefault();
            // Toggle the "open" class to show/hide the dropdown
            dropdown.classList.toggle("open");
        }
    })
}

}


