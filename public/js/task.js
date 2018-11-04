var task = {
    //Fonction de mise à jour d'une tache
    updateTask:function() {
        $(document).on('click', '.edit-task', function () {
        $('.edit-task').hide();
        //Recupère l'id de la tache à modifier
        var taskId = $(this).attr('data-task-id');

        //récupère l'url courrante
        var url = window.location.href;

        //split l'url sur la base des /
        var arr = url.split('/');

        //reconstitue l'url
        var host = arr[0]+'//'+arr[2];

        //recupère la meta csrf de la page
        var csrf = $('meta[name="csrf-token"]').attr('content');

        //Récupère le contenu du span
        var content = $('#task-'+ taskId).html();
        //split le span avec '|'
        var array = content.split('|');
        //recupère et trim le contenu du tableau de chaine
        var inputVal = array[0].trim();

        //Crée le form
        var form = '<div class="update-task-js">';
        form += '<form method=\"POST\" action=\"'+ host +'/task/'+ taskId +'\" class="form-inline">';
        form += '<input name="_method" type="hidden" value="PUT">';
        form += '<input name="_token" type="hidden" value="'+ csrf +'">';
        form += '<input name="value" value="'+ inputVal +'" class="form-control">';
        form += '<input name="type" type="hidden" value="taskcontent" class="form-control">';
        form += '<button class="btn btn-warning">Mettre à jour</button>';
        form += '</form>';
        form += '</div>';

        //Ajoute le form à la page
        $('#task-'+ taskId).html(form);
    });
    },

    updateTaskDoneOrNot:function () {
        /* The todo list plugin */
        $('.todo-list').todoList({
            onCheck  : function () {
                //recupere la task id
                var taskid = $(this).data('taskid');

                $.ajax({
                    method: "PUT",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'https://'+location.host+'/task/'+taskid,
                    data: { type:'status', value:0 },
                    beforeSend:function () {
                        $('.ajax-spinner').show();
                    },
                    success:function () {
                        $('.ajax-spinner').hide();
                    }
                });
            },
            onUnCheck: function () {
                //recupere la task id
                var taskid = $(this).data('taskid');

                $.ajax({
                    method: "PUT",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: 'https://'+location.host+'/task/'+taskid,
                    data: { type:'status', value:1 },
                    beforeSend:function () {
                        $('.ajax-spinner').show();
                    },
                    success:function () {
                        $('.ajax-spinner').hide();
                    }
                });
            }
        });
    }
};