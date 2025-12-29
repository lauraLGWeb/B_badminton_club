//******************************
// ========================
//  variables
// ========================
//******************************
 const btndarkMode = document.querySelector(".btnsHeader")
 const body = document.querySelector("body")




//******************************
// ========================
//  local storage
// ========================
//******************************


//******************************
// ========================
//  main page
// ========================
//******************************

// ------------------------
//  button light dark mode
// -------------------------

// let actualTheme = localStorage.getItem("theme");
// if (actualTheme === "dark") {
//     body.classList.add("dark");
// } else {
    

// }

btndarkMode.addEventListener("click", function () {
    body.classList.toggle("dark")
    console.log(body);
    


})