$(document).ready(function () {
    $('#form-modifier-departement').submit(function (e) {
        e.preventDefault();

        // Récupérer les données du formulaire
        var formData = $(this).serialize();
        var departementId = {{ departement.id }
    };  // Remplacez par le bon moyen d'obtenir l'ID du département

    // Envoyer les données du formulaire au serveur via Ajax
    $.ajax({
        url: '/modifier-departement/' + departementId,
        method: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                alert('Modification du département réussie !');
            } else {
                alert('Échec de la modification du département.');
            }
        },
        error: function () {
            alert('Une erreur s\'est produite lors de la soumission du formulaire.');
        }
    });
});
});
