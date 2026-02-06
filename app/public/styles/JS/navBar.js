//******************************
// ========================
//  variables
// ========================
//******************************
 
const menuIcon = document.getElementById("menuIcon")
const closeBtnMenu = document.querySelector(".closeBtnMenu")
const navLink = document.querySelector(".nav-links")
const dropdowns = document.querySelectorAll(".dropdown");



//******************************
// ========================
//  main page
// ========================
//******************************

//open the menu
  menuIcon.addEventListener("click", function () {
    navLink.style.display = "flex";
    menuIcon.style.display = "none";
    navLink.classList.add("active");
    
});
//close the menu
closeBtnMenu.addEventListener("click", function () {
    navLink.style.display = "none";
    menuIcon.style.display = "block";
    
});

// menu change when dropp down on main page 

for(let dropdown of dropdowns){
    const Mainlink = dropdown.querySelector("a")

Mainlink.addEventListener("click", function(e){
    if(navLink.classList.contains("active")){
         e.preventDefault();
         dropdown.classList.toggle("open");

    }

    })

}
