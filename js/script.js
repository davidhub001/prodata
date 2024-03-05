
    // Fonction pour afficher la fenêtre popup avec le formulaire
    function afficherPopup(id_client) {
        // Créez ici le contenu HTML de votre formulaire
        var formulaireHTML = '<form id="monFormulaire" method="post" class="popup-container">' +
                            '<span id="close_popup">&#10006;</span>'+
                            '<input type="hidden" name="id_client" id ="id_client" value="'+id_client+'">' +
                            '<label for="nom">Nom:</label>' +
                            '<input type="text" id="nom" name="nom">' +
                            '<br>' +
                            '<label for="email">Email:</label>' +
                            '<input type="email" id="email" name="email">' +
                            '<br>' +
                            '<input type="submit" value="Envoyer">' +
                            '</form>';
        var body = document.body;

        // Créez un élément div pour contenir le formulaire
        var popupContainer = document.createElement('div');
        popupContainer.innerHTML = formulaireHTML;
        
        // Ajoutez la classe pour le style (vous pouvez ajuster cela en fonction de votre CSS)
        popupContainer.classList.add('popup-container-main');

        // Affichez la fenêtre popup
        document.body.appendChild(popupContainer);

        var close_popup = document.getElementById("close_popup");
        close_popup.onclick = () => {
            document.body.removeChild(popupContainer);
        }

        body.classList.add("prodata_desactive_body");
        // Gérez l'événement de soumission du formulaire
        popupContainer.querySelector('#monFormulaire').addEventListener('submit', function (event) {
            event.preventDefault();

            // Effectuez ici l'appel AJAX pour traiter le formulaire
            var xhr = new XMLHttpRequest();
            xhr.open('POST', ajax_object.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

            var formData = {
                "action": "prodata_traiter_formulaire",
                "nom": encodeURIComponent(popupContainer.querySelector('#nom').value),
                "email": encodeURIComponent(popupContainer.querySelector('#email').value),
                "id_client": encodeURIComponent(popupContainer.querySelector('#id_client').value),
              };
            
            // Convertir l'objet en une chaîne de requête d'URL
            var queryString = Object.keys(formData)
            .map(key => `${encodeURIComponent(key)}=${formData[key]}`)
            .join('&');
            
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

            xhr.send(queryString);
        });
    }