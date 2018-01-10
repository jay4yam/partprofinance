var editProspect = {
    test:true,

    /**
     * showEditButton :  Fonction appelé depuis la vue "prospects.edit"
     * Affiche/Efface le bouton de MAJ
     */
    showEditButton:function () {
        $('td.data').on('mouseover', function () {
            $(this).children('.updateData').toggle();
        });
        $('td.data').on('mouseout', function () {
            $(this).children('.updateData').toggle();
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
    },

    /**
     * Affiche le camembert endettement
     */
    graphEndettement:function (charges, revenus) {
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieChart       = new Chart(pieChartCanvas);
        var PieData        = [
            {
                value    : revenus,
                color    : '#00c0ef',
                highlight: '#00c0ef',
                label    : 'Revenus'
            },
            {
                value    : 500,
                color    : '#f39c12',
                highlight: '#f39c12',
                label    : 'Charges'
            }
        ];
        var pieOptions     = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke    : true,
            //String - The colour of each segment stroke
            segmentStrokeColor   : '#fff',
            //Number - The width of each segment stroke
            segmentStrokeWidth   : 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps       : 100,
            //String - Animation easing effect
            animationEasing      : 'easeOutBounce',
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate        : true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale         : false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive           : true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio  : true,
            //String - A legend template
            legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
        };
        //Create pie or douhnut chart
        // You can switch between pie and Doughnut using the method below.
        pieChart.Pie(PieData, pieOptions);
    }
};

