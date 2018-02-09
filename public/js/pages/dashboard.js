/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict';

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder         : 'sort-highlight',
    connectWith         : '.connectedSortable',
    handle              : '.box-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });
  $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

  // jQuery UI sortable for the todo list
  $('.todo-list').sortable({
    placeholder         : 'sort-highlight',
    handle              : '.handle',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });

  /* The todo list plugin */
  $('.todo-list').todoList({
    onCheck  : function () {
        //recupere la task id
        var taskid = $(this).data('taskid');

        $.ajax({
            method: "PUT",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'http://'+location.host+'/task/'+taskid,
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
            url: 'http://'+location.host+'/task/'+taskid,
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
});