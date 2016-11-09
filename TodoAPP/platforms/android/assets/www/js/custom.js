$(document).ready(function() {
    init();
    $('.modal-trigger').leanModal();
});

function init() {
    $.ajax({
        type: 'get',
        url: 'YOUR-URL', //URL can be your localhost IP if you are testing it on Your Local Network Or Your WebServer 
        dataType: 'json', // expected returned data format.
        statusCode: {
                200: function (response) {
                    $.each(response, function(index, value) {

                    $("#todo").append("<li class='collection-item'><div>" + value.todo + " <a class='secondary-content' onclick='view(" + value.id + ")'><i class='material-icons right'>send</i></a><a class='secondary-content' onclick='deletes(" + value.id + ")'><i class='material-icons right'>delete</i></a><a class='secondary-content' onclick='edits(" + value.id + ")'><i class='material-icons right'>edit</i></a></div></li>");
                });
                },
                422: function (response) {
                    Materialize.toast('Error Getting Data', 4000);
                },
                400: function (response) {
                    Materialize.toast('URL Not Found', 4000);
                }
            }
    });

}

function view(id) {
    url = 'YOUR-URL' + id + "/";
    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json', // expected returned data format.
        statusCode: {
                200: function (response) {
                    $.each(response, function(index, value) {
                    $("#title").html(value.todo);
                    $("#cat").html(value.category);
                    $("#desc").html(value.description);

            });

            $('#modal1').openModal();
                },
                422: function (response) {
                    Materialize.toast('Error Getting Data', 4000);
                },
                400: function (response) {
                    Materialize.toast('URL Not Found', 4000);
                }
            }
    });

}

function deletes(id) {

    url = 'YOUR-URL' + id + '/';
    $.ajax({
        type: 'delete',
        url: url,
        statusCode: {
                200: function (response) {
                    $("#todo").load(location.href + " #todo");
                    init();
                    Materialize.toast('Deleted', 4000);
                },
                422: function (response) {
                    Materialize.toast('Error Getting Data', 4000);
                },
                400: function (response) {
                    Materialize.toast('URL Not Found', 4000);
                }
            }
    });
}


function addtodo() {

    todo = $("#todo2").val();
    desc = $("#desc2").val();
    cat = $("#cat2").val();
    if ( todo == "" || desc == "" || cat == "") {

        Materialize.toast('All Fields are Required', 4000);
    }
    else{
    url = 'YOUR-URL';
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
          statusCode: {
                200: function (response) {
                    console.log("here");
                    Materialize.toast('Todo Inserted', 4000);
                    $('#modal2').closeModal();
                    $("#todo").load(location.href + " #todo");
                    init();
                },
                422: function (response) {
                    Materialize.toast(response['responseText'], 4000);
                },
                400: function (response) {
                    Materialize.toast('URL Not Found', 4000);
                }
            }
      });

   }
  }
  
  function edits(id)
  {
    url = 'YOUR-URL' + id + "/";
    $.ajax({
    // Post select to url.
    type: 'get',
    url: url,
    dataType: 'json', // expected returned data format.
    statusCode: {
        200: function (response) {
            modeldata = response;
            $.each(response, function(index, value) {

                $("#todo3").val(value.todo);
                $("#cat3").val(value.category);
                $("#desc3").val(value.description);

                });
            $( "#upbt" ).remove();
            $("#bt").append("<a class='waves-effect waves-light btn' id='upbt' onclick='updatetodo("+id+")'>Update</a>");
            $('#modal3').openModal();
                },
                422: function (response) {
                    Materialize.toast(response['responseText'], 4000);
                },
                400: function (response) {
                    Materialize.toast('URL Not Found', 4000);
                }
            },
        });
    }
  function updatetodo(id) {

    todo = $("#todo3").val();
    desc = $("#desc3").val();
    cat = $("#cat3").val();
    if ( todo == "" || desc == "" || cat == "") {

        Materialize.toast("You Can't Update Emtpy Fields", 4000);
    }
    else{
    url = 'YOUR-URL' + id + "/";
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
          statusCode: {
                200: function (response) {
                    Materialize.toast('Updated Successfully', 4000);
                    $('#modal3').closeModal();
                    $("#todo").load(location.href + " #todo");
                    init();
                },
                 422: function (response) {
                      Materialize.toast(response['responseText'], 4000);
                    },
                400: function (response) {
                    Materialize.toast('URL Not Found', 4000);
                }
            },
        });
    }
}  


