
    // Fonction pour afficher la fenêtre popup avec le formulaire
    function afficherPopup() {
        // Créez ici le contenu HTML de votre formulaire
        var formulaireHTML = '<form id="monFormulaire">' +
                            '<label for="nom">Nom:</label>' +
                            '<input type="text" id="nom" name="nom">' +
                            '<br>' +
                            '<label for="email">Email:</label>' +
                            '<input type="email" id="email" name="email">' +
                            '<br>' +
                            '<input type="submit" value="Envoyer">' +
                            '</form>';

        // Créez un élément div pour contenir le formulaire
        var popupContainer = document.createElement('div');
        popupContainer.innerHTML = formulaireHTML;

        // Ajoutez la classe pour le style (vous pouvez ajuster cela en fonction de votre CSS)
        popupContainer.classList.add('popup-container');

        // Affichez la fenêtre popup
        document.body.appendChild(popupContainer);

        // Gérez l'événement de soumission du formulaire
        popupContainer.querySelector('#monFormulaire').addEventListener('submit', function (event) {
            event.preventDefault();

            // Effectuez ici l'appel AJAX pour traiter le formulaire
            var xhr = new XMLHttpRequest();
            xhr.open('POST', ajax_object.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

            var formData = 'action=prodata_traiter_formulaire&nom=' + encodeURIComponent(popupContainer.querySelector('#nom').value) +
                            '&email=' + encodeURIComponent(popupContainer.querySelector('#email').value);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Fermez la fenêtre popup après le traitement réussi
                    document.body.removeChild(popupContainer);
                    console.log(xhr.responseText);
                } else {
                    console.error('Erreur lors de la requête Ajax');
                }
            };

            xhr.onerror = function () {
                console.error('Erreur lors de la requête Ajax');
            };

            xhr.send(formData);
        });
    }