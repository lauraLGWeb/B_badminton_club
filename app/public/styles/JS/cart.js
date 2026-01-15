
// wait until the page is loaded
document.addEventListener('DOMContentLoaded', function() {
    
    const forms = document.querySelectorAll('.add-to-cart-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) { 
            
            const sizeSelect = form.querySelector('.size');
            const genderSelect = form.querySelector('.gender');
            
           
            if (sizeSelect && genderSelect) {
                if (sizeSelect.value === '' || genderSelect.value === '') {
                    e.preventDefault(); // Empêche l'envoi du formulaire
                    alert('Veuillez sélectionner une taille et un genre avant d\'ajouter au panier.');
                    return false;
                }
            }
            
           //if select, then ok the form is sent
        });
    });
});