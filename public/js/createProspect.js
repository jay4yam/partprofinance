/**
 * Fichier create prospect
 * @type {{}}
 */
var createProspect = {

    //Fonction qui gère l'insertion d'une nouvelle ligne de credit
    addCredit:function () {
        $('#addCreditButton').on('click', function (e) {
           e.preventDefault();
           //Recupère la dernière ligne du tableau
           var derniereLigneTableau = $('#chargesTable tr:last');

           //Récupère l'attribut id de cette ligne (id="creditrow-i")
           var getCreditId = derniereLigneTableau.attr('id');
           var getId = getCreditId.split('-');

           //Init l'id qui sera passé pour récupérer l'id du dernier index du tableau
           var id = Number( getId[1] );

           //Dessine le nouvel table row avec les deux nouveaux inputs
           var newTr = '<tr id="creditrow-'+ (id+1) +'">';
               newTr += '<td><input id="credit-name-'+ (id+1) +'" name="credit-name-'+ (id+1) +'" class="form-control" type="text" placeholder="nom credit"></td>';
               newTr += '<td><input id="credit-montant-'+ (id+1) +'" name="credit-montant-'+ (id+1) +'" class="form-control" type="text" placeholder="montant credit"></td>';
               newTr += '</tr>';

            derniereLigneTableau.after(newTr);
        });
    }
    
};