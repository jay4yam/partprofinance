var editProspect = {
    test:true,

    /**
     * showEditButton :  Fonction appelé depuis la vue "prospects.edit"
     * Affiche/Efface le bouton de MAJ
     */
    showEditButton:function () {
        $('td.data').on('mouseover', function () {
            $(this).children('.updateData').toggle();
            $(this).children('.deleteCredit').toggle();
        });
        $('td.data').on('mouseout', function () {
            $(this).children('.updateData').toggle();
            $(this).children('.deleteCredit').toggle();
        });
    },

    /**
     * Fonction appelé depuis la vue "prospects.edit"
     * Gère les actions JS lors du click sur le bouton "MAJ" affiché dans le <td> ciblé
     */
    clickOnEditButton:function () {
        //Sur le click du bouton 'updateData'
        $(document).on('click', '.updateData', function (e) {
            e.preventDefault();
            //1. récupère le cle de la data à updater
            var dataKey = $(this).parent().attr('id');

            //2. récupère l'ancienne valeur associe à la clé
            var dataValue = $(this).parent().children('.value').text();

            //3. affiche l'input si test est vrai
            if(editProspect.test) {
                //4. utilise la méthode showinput pour afficher les inputs qui vont bien (input, list, etc..)
                editProspect._showInput($(this).parent(), dataKey, dataValue);

                //test à false pour empêcher d'afficher un autre bouton .sauv
                editProspect.test = false;
            }

            //4. utilisation de la methode privée sendUpdate
            editProspect._sendUpdate(dataKey);
        });
    },

    /**
     * Met à jour les notes
     */
    ajaxUpdateNotes:function () {
        $('#ajaxnotesupdate').on('click', function (e) {
            e.preventDefault();

            //1. récupère l'id du prospect à updater
            var pathName = location.pathname;
            var array = pathName.split('/');
            var prospectId = array[array.length-1];

            var id = 'notes';
            var value = $('#notes').val();

            $.ajax({
                method: "PUT",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'http://'+location.host+'/prospect/'+prospectId,
                data: {id:id, value:value},
                beforeSend:function () {
                    $('.ajax-spinner').show();
                }
            }).done(function (message) {
                //1. masque le spinner ajax
                $('.ajax-spinner').hide();

                //3. si message = success
                if(message.success){
                    //On modifie le contenu
                    $('#notes').val(value);
                }
            });
        });
    },

    /**
     * Ajoute un nouveau credit
     */
    addCredit:function () {
        $('#addCreditButton').on('click', function (e) {
            e.preventDefault();

            //recupère la dernière ligne du tableau
            // ajoute les inputs via la méthode privée _drawNewTableRow()
            $('#chargesTable tr:last').after( editProspect._drawNewTableRow() );

            //Utilisation methode privee avec requete ajax pour ajout d'un credit
            editProspect._ajaxAddCredit();
        });
    },

    /**
     * Supprime un crédit
     */
    deleteCredit: function () {
        $('.deleteCredit').on('click', function (e) {
            e.preventDefault();
            //1. init la var qui contient le lien
            var tr = $(this).closest('tr');

            //2. recupere le nom du credit
            var creditToDelete = $(tr).find('td').html();

            //3. détermine le prospect à modifier
            //récupère l'id du prospect à updater
            var pathName = location.pathname;
            var array = pathName.split('/');
            var prospectId = array[array.length-1];

            //4. Requête ajax vers l'url de suppression de prospect (voir route web.php)
            $.ajax({
                method: "DELETE",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'http://'+location.host+'/prospect/delete-credit/'+prospectId,
                data: {creditToDelete:creditToDelete},
                beforeSend:function () {
                    $('.ajax-spinner').show();
                }
            }).done(function (message) {
                //1. masque le spinner ajax
                $('.ajax-spinner').hide();
                if(message.success)
                {
                    tr.remove();
                }
            });
        });
    },

    /**
     * Dessine une nouvelle table row avec deux inputs (creditname, creditValue) pour sauv. les données
     * @returns {string}
     * @private
     */
    _drawNewTableRow:function () {
    var tr = '<tr>';
        tr += '<td><input class="form-control" id="creditName" name="creditName" placeholder="nom credit"></td>';
        tr += '<td>';
        tr += '<div class="input-group">';
        tr += '<input class="form-control" id="creditValue" name="creditValue" placeholder="montant credit">';
        tr += '<div class="input-group-btn">';
        tr += '<button type="button" id="AddCredit" class="btn btn-success">';
        tr += '<i class="fa fa-floppy-o" aria-hidden="true"></i> Sauv.</button></div></div>';
        tr += '</td></tr>';

        return tr;
    },

    /**
     * AJoute un credit, insertion en base du nom et du montant
     * Changement du td si ajax success
     * @private
     */
    _ajaxAddCredit:function () {
      //si on observe un click sur le bouton ='addcredit'
      $('#AddCredit').on('click',function (e) {
          e.preventDefault();
          //recup le nom de credit
          var creditName = $('#creditName').val();
          //recup le montant du credit
          var creditValue = $('#creditValue').val();

          //récupère l'id du prospect à updater
          var pathName = location.pathname;
          var array = pathName.split('/');
          var prospectId = array[array.length-1];

          //Requête ajax d'ajout de credit (voir route web.php)
          //envois des datas creditName et creditValue
          $.ajax({
            method: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'http://'+location.host+'/prospect/add-credit/'+prospectId,
            data: {creditName:creditName, creditValue:creditValue},
            beforeSend:function () {
                $('.ajax-spinner').show();
            }
        }).done(function (message) {
            //1. masque le spinner ajax
            $('.ajax-spinner').hide();
            //Si la requête est OK, on réaffiche la ligne  du tableau contenant le nom du credit et le montant
            if(message.success)
            {
                var tr = $('#chargesTable tr:last');
                var td = '<td>'+creditName+'</td><td><b>'+creditValue+' €</b></td>';
                tr.html(td);
            }
        });
      });
    },

    /**
     * Affiche le bon type d'input : input, dropdownlist, etc...
     * @param ObjetTd
     * @param dataKey
     * @param dataValue
     */
    _showInput:function (ObjetTd, dataKey, dataValue) {
        var arrayList = [];
        var selected =[];
        var input ='';
        switch (dataKey){
            case 'civilite':
                selected = dataValue='Madame' ? '' : 'selected';
                input = '<div class="input-group">';
                input += '<select class="form-control" id="'+dataKey+'" name="'+dataKey+'">';
                input += '<option value="Madame" '+selected+'>Madame</option>';
                input += '<option value="Monsieur" '+selected+'>Monsieur</option>';
                input += '</select>';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'situationFamiliale':
                arrayList = ['Célibataire','Marié(e)','Divorcé(e)','Vie maritale/Pacs','Veuf(ve)'];
                for(var i = 0; i < arrayList.length; i++ )
                {
                    if(arrayList[i] == dataValue){ selected[i] = 'selected'; }
                    else{ selected[i] = '';}
                }
                input = '<div class="input-group">';
                input += '<select class="form-control" id="'+dataKey+'" name="'+dataKey+'">';
                input += '<option value="Célibataire" '+selected[0]+'>Célibataire</option>';
                input += '<option value="Marié(e)" '+selected[1]+'>Marié(e)</option>';
                input += '<option value="Divorcé(e)" '+selected[2]+'>Divorcé(e)</option>';
                input += '<option value="Vie maritale/Pacs" '+selected[3]+'>Vie maritale/Pacs</option>';
                input += '<option value="Veuf(ve)" '+selected[4]+'>Veuf(ve)</option>';
                input += '</select>';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'habitation':
                arrayList = ['Accèdent à la propriété','Propriétaire','Locataire','Logé par la famille','Logé par employeur','autre'];
                for(i = 0; i < arrayList.length; i++ ) {
                    if(arrayList[i] === dataValue){ selected[i] = 'selected'; }
                    else{ selected[i] = '';}
                }
                input = '<div class="input-group">';
                input += '<select class="form-control" id="'+dataKey+'" name="'+dataKey+'">';
                input += '<option value="Accèdent à la propriété" '+selected[0]+'>Accèdent à la propriété</option>';
                input += '<option value="Propriétaire" '+selected[1]+'>Propriétaire</option>';
                input += '<option value="Locataire" '+selected[2]+'>Locataire</option>';
                input += '<option value="Logé par la famille" '+selected[3]+'>Logé par la famille</option>';
                input += '<option value="Logé par employeur" '+selected[4]+'>Logé par employeur</option>';
                input += '<option value="autre" '+selected[5]+'>autre</option>';
                input += '</select>';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'secteurActivite':
                arrayList = ['Secteur privé','Secteur public','Secteur agricole','Artisans-Commerçants','Professions libérales','Autres'];
                for(i = 0; i < arrayList.length; i++ )
                {
                    if(arrayList[i] === dataValue){ selected[i] = 'selected'; }
                    else{ selected[i] = '';}
                }
                input = '<div class="input-group">';
                input += '<select class="form-control" id="'+dataKey+'" name="'+dataKey+'">';
                input += '<option value="Secteur privé" '+selected[0]+'>Secteur privé</option>';
                input += '<option value="Secteur public" '+selected[1]+'>Secteur public</option>';
                input += '<option value="Secteur agricole" '+selected[2]+'>Secteur agricole</option>';
                input += '<option value="Artisans-Commerçants" '+selected[3]+'>Artisans-Commerçants</option>';
                input += '<option value="Professions libérales" '+selected[4]+'>Professions libérales</option>';
                input += '<option value="Autres" '+selected[5]+'>Autres</option>';
                input += '</select>';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'secteurActiviteConjoint':
                arrayList = ['Secteur privé','Secteur public','Secteur agricole','Artisans-Commerçants','Professions libérales','Autres'];
                for(i = 0; i < arrayList.length; i++ )
                {
                    if(arrayList[i] === dataValue){ selected[i] = 'selected'; }
                    else{ selected[i] = '';}
                }
                input = '<div class="input-group">';
                input += '<select class="form-control" id="'+dataKey+'" name="'+dataKey+'">';
                input += '<option value="Secteur privé" '+selected[0]+'>Secteur privé</option>';
                input += '<option value="Secteur public" '+selected[1]+'>Secteur public</option>';
                input += '<option value="Secteur agricole" '+selected[2]+'>Secteur agricole</option>';
                input += '<option value="Artisans-Commerçants" '+selected[3]+'>Artisans-Commerçants</option>';
                input += '<option value="Professions libérales" '+selected[4]+'>Professions libérales</option>';
                input += '<option value="Autres" '+selected[5]+'>Autres</option>';
                input += '</select>';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'dateDeNaissance':
                var array = dataValue.split('/');
                var date = array[2]+'-'+array[1]+'-'+array[0];
                input = '<div class="input-group">';
                input += '<input type="date" class="form-control" id="'+dataKey+'" name="'+dataKey+'" value="'+date+'">';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'professionDepuis':
                var array = dataValue.split('/');
                var date = array[2]+'-'+array[1]+'-'+array[0];
                input = '<div class="input-group">';
                input += '<input type="date" class="form-control" id="'+dataKey+'" name="'+dataKey+'" value="'+date+'">';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'professionDepuisConjoint':
                var array = dataValue.split('/');
                var date = array[2]+'-'+array[1]+'-'+array[0];
                input = '<div class="input-group">';
                input += '<input type="date" class="form-control" id="'+dataKey+'" name="'+dataKey+'" value="'+date+'">';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'habiteDepuis':
                var array = dataValue.split('/');
                var date = array[2]+'-'+array[1]+'-'+array[0];
                input = '<div class="input-group">';
                input += '<input type="date" class="form-control" id="'+dataKey+'" name="'+dataKey+'" value="'+date+'">';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            case 'BanqueDepuis':
                var array = dataValue.split('/');
                var date = array[2]+'-'+array[1]+'-'+array[0];
                input = '<div class="input-group">';
                input += '<input type="date" class="form-control" id="'+dataKey+'" name="'+dataKey+'" value="'+date+'">';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
                break;
            default:
                input = '<div class="input-group">';
                input += '<input class="form-control" id="'+dataKey+'" name="'+dataKey+'" value="'+dataValue+'">';
                input += '<div class="input-group-btn">';
                input += '<button type="button" id="updateSend" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Sauv.</button>';
                input += '</div>';
                input += '</div>';
                ObjetTd.html(input);
        }
    },

    /**
     * sendUpdate : gère le click sur le bouton "maj" affiché après le click de l'utilisareur
     * @param datakey : type de data à mettre à jour
     */
    _sendUpdate:function (datakey) {
        $('#updateSend').on('click', function (e) {
            e.preventDefault();

            //1. Recupere le <td> parent qui contient toutes les datas
            var tdParent = $(this).closest('td');
            var inputGroup = tdParent.children();

            //2. Récupère la select ou l'input qui contient les datas
            var inputItem = inputGroup.children()[0];

            //3. init la valeur a envoyer en base
            var newValue ='';

            //4. test si l'input est un input ou un select
            if( $(inputItem).is('input') )
            {
                newValue = $(inputItem).val();
            }else {
                newValue = $(inputItem).find(":selected").text();
            }

            //5. Utilisation de la méthode privée _ajaxUpdate pour mettre à jour les données
            editProspect._ajaxUpdate($(inputItem), datakey, newValue);
        });

    },

    /**
     * ajaxUpdate : Méthode privée qui gère la requête ajax de MAJ
     * @param id = colonne de la base à updater
     * @param value = nouvelle valeur à mettre à jour
     */
    _ajaxUpdate:function (htmlObject,id, value) {

        //1. récupère l'id du prospect à updater
        var pathName = location.pathname;
        var array = pathName.split('/');
        var prospectId = array[array.length-1];

        //2. Requête ajax jquery
        $.ajax({
            method: "PUT",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'http://'+location.host+'/prospect/'+prospectId,
            data: {id:id, value:value},
            beforeSend:function () {
                $('.ajax-spinner').show();
            }
        }).done(function (message) {
            //1. masque le spinner ajax
            $('.ajax-spinner').hide();

            //2. si message = fail
            if(message.fail){
                $(htmlObject).css('border', 'solid 1px red');
            }
            //3. si message = success
            if(message.success){
                //Utilisation methode _reDrawTd privée qui réaffiche le td
                editProspect._reDrawTd(htmlObject, value);
            }
        });
    },

    /**
     * Redéfini le contenu de la balise td originale
     * @param objectInput
     * @param newValue
     * @private
     */
    _reDrawTd:function (objectInput, newValue) {
        //Récupère le td le plus proche de l'objet
        var tdCible = $(objectInput).closest('td');

        //contenu la balise td
        var content = '<b class="value">'+ newValue +'</b>';
            content += '<a href="#" class="updateData pull-right btn-xs btn-success">';
            content += '<i class="fa fa-pencil" aria-hidden="true"></i>';
            content += '</a>';

        //insére le contenu dans la balise td
        $(tdCible).html(content);

        //remet la variable test à true
        editProspect.test = true;
    }
};

