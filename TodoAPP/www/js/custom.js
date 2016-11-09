$(document).ready(function() {
    init();
    $('.modal-trigger').leanModal();
});
modaldata = null;

function init() {
    $.ajax({
        // Post select to url.
        type: 'get',
        url: 'http://phpstack-13267-58835-157206.cloudwaysapps.com/todo/',
        dataType: 'json', // expected returned data format.
        success: function(data) {

            $.each(data, function(index, value) {

                $("#todo").append("<li class='collection-item'><div>" + value.todo + " <a class='secondary-content' onclick='view(" + value.id + ")'><i class='material-icons right'>send</i></a><a class='secondary-content' onclick='deletes(" + value.id + ")'><i class='material-icons right'>delete</i></a><a class='secondary-content' onclick='edits(" + value.id + ")'><i class='material-icons right'>edit</i></a></div></li>");
            });
        }
    });

}

function view(id) {
    url = 'http://phpstack-13267-58835-157206.cloudwaysapps.com/todo/' + id + "/";
    $.ajax({
        // Post select to url.
        type: 'get',
        url: url,
        dataType: 'json', // expected returned data format.
        success: function(data) {
            modeldata = data;
            $.each(data, function(index, value) {

                $("#title").html(value.todo);
                $("#cat").html(value.category);
                $("#desc").html(value.description);

            });

            $('#modal1').openModal();

        }
    });

}

function deletes(id) {

    url = 'http://phpstack-13267-58835-157206.cloudwaysapps.com/todo/' + id + '/';
    $.ajax({
        // Post select to url.
        type: 'delete',
        url: url,
        success: function(data) {

            if (data == "deleted") {
                $("#todo").load(location.href + " #todo");
                init();
                Materialize.toast('Deleted', 4000);

            }

        }
    });
}


function addtodo() {

    todo = $("#todo2").val();
    desc = $("#desc2").val();
    cat = $("#cat2").val();
    if ( todo == null || desc == null || cat == null) {

        Materialize.toast('All Fields are Required', 4000);
    }
    else{
    url = 'http://phpstack-13267-58835-157206.cloudwaysapps.com/todo/';
      $.ajax(
      {
          // Post select to url.
          type : 'post',
          url : url,
          data : {
            todo : this.todo,
            desc : this.desc,
            cat : this.cat
          },
          success : function(data){

               if(data == "inserted"){
                
                Materialize.toast('Todo Inserted', 4000);
                $('#modal2').closeModal();
                $("#todo").load(location.href + " #todo");
                init();
               }

          }
      });

    }
  }

    function edits(id)
    {
      url = 'http://phpstack-13267-58835-157206.cloudwaysapps.com/todo/' + id + "/";
      $.ajax({
        // Post select to url.
        type: 'get',
        url: url,
        dataType: 'json', // expected returned data format.
        success: function(data) {
            modeldata = data;
            $.each(data, function(index, value) {

                $("#todo3").val(value.todo);
                $("#cat3").val(value.category);
                $("#desc3").val(value.description);

            });
            $( "#upbt" ).remove();
            $("#bt").append("<a class='waves-effect waves-light btn' id='upbt' onclick='updatetodo("+id+")'>Update</a>");
            $('#modal3').openModal();

        }
      });
    }
  function updatetodo(id) {

    todo = $("#todo3").val();
    desc = $("#desc3").val();
    cat = $("#cat3").val();
    if ( todo == null || desc == null || cat == null) {

        Materialize.toast('All Fields are Required', 4000);
    }
    else{
    url = 'http://phpstack-13267-58835-157206.cloudwaysapps.com/todo/' + id + "/";
      $.ajax(
      {
          // Post select to url.
          type : 'put',
          url : url,
          data : {
            todo : this.todo,
            desc : this.desc,
            cat : this.cat
          },
          success : function(data){

               if(data == "updated"){
                
                Materialize.toast('Updated Successfully', 4000);
                $('#modal3').closeModal();
                $("#todo").load(location.href + " #todo");
                init();
               }

          }
      });

    }
  }  


