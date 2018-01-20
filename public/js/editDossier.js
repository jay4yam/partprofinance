/*
    Js de la vue : Dossier/Edit
 */

var dossierJS = {

    /**
     * Utilisée dans la vue dossiers.edit
     */
    changeMontantDemande : function () {
        //Fonction qui change les montants en recalculant les champs
        // montant_demande , montant_final, ou commission
        $('#montant_demande').on('change', function (e) {
            e.preventDefault();

            //recupere le nouveau montant demande
            var new_montant_damande = $(this).val();

            //receupere le taux de commission
            var tauxCommission = $('#taux_commission').val();

            //calcul la  nouvelle commission de partprofinance
            var new_montant_commission_partpro = new_montant_damande * tauxCommission / 100;

            //Affiche le nouveau montant de la commission
            $('#montant_commission_partpro').val(new_montant_commission_partpro);

            //calcul le nouveau montant final
            var new_montant_final = parseFloat(new_montant_damande) + parseFloat(new_montant_commission_partpro);

            //affiche le nouveau montant final
            $('#montant_final').val(new_montant_final);
        });
    },

    /**
     * Utilisée dans la vue dossiers.create
     */
    autocompleteNom:function () {

        //url requête ajax
        var url = 'http://'+location.host+'/dossier/prospect/autocomplete/name';

        //Auto complete jquery
        $('#nom').autocomplete({
            minLength:3,
            dataType: "json",
            // source de données via requete ajax
            // la subtilité c'est d'utiliser un callback pour récupérer la requête et la response
            source: function (request, response) {
                $.ajax({
                    method: "GET",
                    headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('content')},
                    url: url,
                    data: { term: request.term },
                    beforeSend: function () {
                        // affiche le spinner avant envois de la requête
                        $('.ajax-spinner').show();
                    },
                    success: function (data) {
                        // supprime le spinner
                        $('.ajax-spinner').hide();
                        // la réponse avec les données est envoyée à la fonction autocomplete
                        // c'est comme ci on avait écrit > source : response (data)
                        response(data);
                        }
                    });
                },
            select:function (event, ui) {
                //insère le user_id dans l'input hidden
                var user_id = ui.item.id;
                $('#user_id').val(user_id);

                //récupère la liste des réponses au format nom-prenom-email
                var items = ui.item.value;

                //split la chaine avec le séparateur '-'
                var array = items.split(' / ');

                //init. les valeurs
                var nom = array[0];
                var prenom = array[1];
                var email = array[2];
                var iban = array[3];

                $('#prenom').val(prenom);
                $('#email').val(email);
                $('#iban').val(iban);

                //reinitialise le ui.item.value avec seulement le nom
                //sinon ca affiche nom-prenom-email (et ce n'est pas la résultat attendu
                ui.item.value = nom;
            }
        });
    }
};