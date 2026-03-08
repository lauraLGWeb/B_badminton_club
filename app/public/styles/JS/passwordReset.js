// first one "nouveau mot de passe "
    const passwordResetOne = document.getElementById("change_password_form_plainPassword_first");
    const viewPictoResetOne = document.getElementById("viewPictoResetOne");
    let hidePwda =true;
    
    const viewPathResetOne = viewPictoResetOne.dataset.view;
    const hidePathResetOne = viewPictoResetOne.dataset.hide;
   
// second one "repeter nouveau mot de passe "
    const passwordResetTwo = document.getElementById("change_password_form_plainPassword_second");
    const viewPictoResetTwo = document.getElementById("viewPictoResetTwo");
    let hidePwdaTwo =true;
    
    const viewPathResetTwo = viewPictoResetTwo.dataset.viewtwo;
    const hidePathResetTwo = viewPictoResetTwo.dataset.hidetwo;



    

// first one "nouveau mot de passe "

     viewPictoResetOne.addEventListener("click", function(){        
         if(hidePwda){
            passwordResetOne.type="text";
            hidePwda=false;
            //change the picture
            viewPictoResetOne.src = hidePathResetOne;  
                      
        } else {
             passwordResetOne.type="password";
             hidePwda=true;
             viewPictoResetOne.src = viewPathResetOne;
        }        
     })

// second one "répeter le nouveau mot de passe "
   
     viewPictoResetTwo.addEventListener("click", function(){
        console.log("coucou");
        
         if(hidePwdaTwo){
            passwordResetTwo.type="text";
            hidePwdaTwo=false;
            //change the picture
            viewPictoResetTwo.src = hidePathResetTwo;  
                      
        } else {
             passwordResetTwo.type="password";
             hidePwdaTwo=true;
             viewPictoResetTwo.src = viewPathResetTwo;
        }        
     })