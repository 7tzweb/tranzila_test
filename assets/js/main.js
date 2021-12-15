$(function() {

    var uri = 'http://localhost/tranzila_test/';
    $('[data-toggle=tooltip]').tooltip();

    $('#todo-from').submit(function(e) {
        e.preventDefault();
        var todoval = $('input[name=todo-input]').val();
        if (todoval == '') {
            alert('isi dulu lah tolo >:(');
            $('input[name=todo-input]').focus();
            return false;
        }

        $.ajax({
            'type': "POST",
            data: {todo: todoval},
            url: uri+'insert',
            dataType: "json",
            beforeSend: function(e) {
                $('#log').html('inserting..')
            },
            error: function(error) {
                $('#log').html('something wrong');
            },
            success: function(response) {
                resetLog();
                $('#nothing').css('display','none');
                $('input[name=todo-input]').val('');
                // $('#todo-container').append(
                // 	"<li data-id="+ response.id +"><span data-id="+ response.id +">"+ response.name +"</span>"+
                // 	"<div class=\"action\">"+
                // 		"<button data-toggle=\"tooltip\" data-title=\"Edit\" class=\"edit-btn\" data-id="+ response.id +"><i class=\"glyphicon glyphicon-pencil\"></i></button>\r\n"+
                // 		"<button data-toggle=\"tooltip\" data-title=\"Done\" class=\"done-btn\" data-id="+ response.id +"><i class=\"glyphicon glyphicon-ok\"></i></button>"+
                // 	"</div>"+
                // "</li>");
                $('#todo-container').append(
                    "<tr data-id="+response.id+">"+
                    "<td>"+response.id+"</td>"+
                    "<td data-task="+response.id+">"+response.name +"</td>"+
                    "<td>"+response.created_at+"</td>"+
                        "<td style=\"position: relative;\">"+
                            "<div class=\"action\">"+
                            "<button data-toggle=\"tooltip\" data-title=\"Edit\" class=\"edit-btn\" data-id="+ response.id +"><i class=\"glyphicon glyphicon-pencil\"></i></button>\r\n"+
                            "<button data-toggle=\"tooltip\" data-title=\"Done\" class=\"done-btn\" data-id="+ response.id +"><i class=\"glyphicon glyphicon-ok\"></i></button>"+
                        "</div>"+
                        "</td>"+
                    "</tr>"
                );
                $('[data-toggle=tooltip]').tooltip();

                //refresh task btn
                var task_r  =   parseInt($('#task_r').html()) ;
                var task_r_m = task_r + 1;
                $('#task_r').text(task_r_m);
                var task_t  =   parseInt($('#task_t').html()) ;
                var task_t_m = task_t + 1;
                $('#task_t').text(task_t_m);
            }
        });
    });

    $('body').on('click','.done-btn',function(e) {
        var id = $(this).attr('data-id');
        if(typeof id == undefined){
            alert("something wrong!!");
            return false;
        }

        $.ajax({
            type :"POST",
            url : uri+'done',
            data:{id:id},
            beforeSend: function(e){
                $("tr[data-id='"+ id +"']").css('background-color','rgba(120, 174, 223,0.2)');
                $("#log").html("loading..");
            },
            error : function(error){
                $('#log').html('something wrong');
            },
            success : function(response){
                $("tr[data-id='"+ id +"']").fadeOut(300);
                setTimeout(function(){
                    $("tr[data-id='"+ id +"']").remove();
                },500);

                //refresh task btn
                var task_r  =   parseInt($('#task_r').html()) ;
                var task_r_m = task_r - 1;
                $('#task_r').text(task_r_m);
                var task_c  =   parseInt($('#task_c').html()) ;
                var task_c_m = task_c + 1;
                $('#task_c').text(task_c_m);

                resetLog();
                checkifempty();
            }
        });
    })

    $('body').on('click','.delete-btn',function(e) {
        var id = $(this).attr('data-id');
        if(typeof id == undefined){
            alert("something wrong!!");
            return false;
        }

        $.ajax({
            type :"POST",
            url : uri+'delete',
            data:{id:id},
            beforeSend: function(e){
                $("tr[data-id='"+ id +"']").css('background-color','rgba(120, 174, 223,0.2)');
                $("#log").html("loading..");
            },
            error : function(error){
                $('#log').html('something wrong');
            },
            success : function(response){
                $("tr[data-id='"+ id +"']").fadeOut(300);
                setTimeout(function(){
                    $("tr[data-id='"+ id +"']").remove();
                },500);

                //refresh task btn
                var task_r  =   parseInt($('#task_r').html()) ;
                var task_r_m = task_r - 1;
                $('#task_r').text(task_r_m);
                var task_c  =   parseInt($('#task_c').html()) ;
                var task_c_m = task_c + 1;
                $('#task_c').text(task_c_m);

                resetLog();
                checkifempty();
            }
        });
    })

    $('body').on('click','.edit-btn',function(e) {
        var id = $(this).attr('data-id');
        if(typeof id == undefined){
            alert("something wrong!!");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: uri+'edit',
            data: {id:id},
            dataType: 'json',
            beforeSend: function(e){
                $("#log").html("loading..");
            },
            error : function(error){
                $('#log').html('something wrong');
            },
            success : function(response){
                resetLog();
                swal({
                  title: "Edit",
                  text: "What will you do then?",
                  type: "input",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
                  animation: "slide-from-top",
                  inputValue: response.name,
                  inputPlaceholder: "Do something"
                },
                function(inputValue){
                    if (inputValue === "" || inputValue === false) {
                        return false;
                    }
                    update(id,inputValue);
                });
            }
        });
    });

    var update = function(id,name){
        $.ajax({
            type:"POST",
            url:uri+'update',
            data:{id:id,todo:name},
            dataType:'json',
            beforeSend: function(e){
                $("#log").html("updating..");
            },
            error : function(error){
                $("#log").html("something wrong");
            },
            success :function(response){
                resetLog();
                $("td[data-task='"+ response.id +"']").html(response.name);
                setTimeout(function(e){
                    swal.close();
                }),300;
            }
        });
        // swal("Ajax request finished!");
    } 
    var resetLog = function() {
        $('#log').html('...');
    }
    var checkifempty = function() {
        $.get(uri+'countTodos', function(response){
            response = $.parseJSON(response);
            if (response[0] == undefined) {
                $('#nothing').css('display','block');
            }
        })
    }




    //tabel sort
   

    var table = $('table');
    
    $('#id_header, #name_header, #date_header')
        .wrapInner('<span title="sort this column"/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            });
                
        });






});