$(function() {

    $('#side-menu').metisMenu();

});



//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    })
});





var dataAdapter;
var source;

$(document).ready(function(){

    
    
    //Modal setting
    $("#showDetailModal").click(function(){
        formUpdate.edit = false;
        formUpdate.schoolId = undefined; 
        $("[name='detailForm']")[0].reset(); 
        $("#lastUpdatedBlock").html('');
        $('#comments_container').empty(); 
        $("#myModalLabel").text("Add Details");     
        $('#detailModal').modal('show'); 
    });
    $('#detailModal').modal({
        show: false,
        backdrop: 'static'
    });  
    //Displaying Others section
    $("[name='pointOfContact']").change(function(){
        if($("[name='pointOfContact']").val()=='others')
        {
            $("#pointOfContactOthersBlock").show();
            $("#othersContactDetailsBlock").show();
        }
        else
        {
            $("#pointOfContactOthersBlock").hide();
            $("#othersContactDetailsBlock").hide();
        }    
    });
    //setting datepicker
    $("[name='dateMet']").datepicker();
    $("[name='nextFollowupDate']").datepicker();

    //calling Auto Calculate deal value
    $("[name='noOfStudents'],[name='priceQuoted']").change(function(){

        if($("[name='noOfStudents']").val() && $("[name='priceQuoted']").val())
        {
            if($.isNumeric($("[name='noOfStudents']").val()) && $.isNumeric($("[name='priceQuoted']").val()))
            {
                $("[name='dealValue']").val($("[name='noOfStudents']").val() * $("[name='priceQuoted']").val());
            }
            else
            {
                if(!$.isNumeric($("[name='noOfStudents']").val())){
                    
                    setTimeout(function(){$("[name='noOfStudents']").focus()},0);
                }
                else
                    setTimeout(function(){$("[name='priceQuoted']").focus()},0);
                alert("Please Enter Numeric Value for Number of students and Price Quoted");
                
            }
        }
    });

    //Saving the changes
    $("#saveChanges").click(function(){
        formUpdate.save();
    });
    //source for jqxgrid
    source = {
                    localdata: gridUpdate.getData(),
                    datafields:
                    [
                        { name: 'name', type: 'string' },
                        { name: 'boardname', type: 'string' },
                        { name: 'city', type: 'string' },
                        { name: 'date_met', type: 'date' },
                        { name: 'deal_value', type: 'number' },
                        { name: 'id', type: 'number' },
                        { name: 'no_of_students', type: 'number' },
                        { name: 'price_quoted', type: 'number' },
                        { name: 'school_name', type: 'string' },
                        { name: 'stage', type: 'string' },

                    ],
                    datatype: "json"
                };
                console.log(source);
                console.log(gridUpdate.getData());
    dataAdapter = new $.jqx.dataAdapter(source);
    //jQwidget stuff
    $("#schoolGrid").jqxGrid(
        {
            width: '100%',            
            showfilterrow: true,
            filterable: true,
            selectionmode: 'singlerow',
            source: dataAdapter,
            showaggregates: true,
            columns: [
              {
                  text: 'Salesman Name', filtertype: 'checkedlist', datafield: 'name', width: 100
              },
              { text: 'School Name', columntype: 'textbox', filtertype: 'input', datafield: 'school_name', width: 350 ,
                    aggregates: ['count'],aggregatesrenderer: function (aggregates) {
                      var value = aggregates['count'];
                      $("#schoolAggregateContainer").text(value);
                      $("#reportTable").show();
                      
                  }
                },
              {
                  text: 'City Name', filtertype: 'checkedlist', datafield: 'city', width: 100
              },
              {
                  text: 'Board Name', filtertype: 'checkedlist', datafield: 'boardname', width: 100
              },
              { text: 'No of Students.', datafield: 'no_of_students', filtertype: 'number',  cellsalign: 'right', width: 100,
                    aggregates: ['sum'],aggregatesrenderer: function (aggregates) {
                      var value = aggregates['sum'];
                      $("#studentAggregateContainer").text(value);
                    }      
                },
              { text: 'Price Quoted', datafield: 'price_quoted', filtertype: 'number',  cellsalign: 'right', width: 100,
                    aggregates: ['avg'],aggregatesrenderer: function (aggregates) {
                      var value = aggregates['avg'];
                      $("#priceQuotedAggregateContainer").text(value);
                    }      
               },
              { text: 'Deal Price.', datafield: 'deal_value', filtertype: 'number',  cellsalign: 'right', width: 100,
                    aggregates: ['sum'] ,aggregatesrenderer: function (aggregates) {
                      var value = aggregates['sum'];
                      $("#dealValueAggregateContainer").text(value);
                    }      
                 },              
              { text: 'Date Met', datafield: 'date_met', filtertype: 'range', width: 200, cellsalign: 'right', cellsformat: 'd' },
              { text: 'Stage.', datafield: 'stage', filtertype: 'checkedlist',  cellsalign: 'right' , width: 100 ,
                     aggregates: [
                          { 'Stage -1':
                            function (aggregatedValue, currentValue) {
                                if (currentValue == "-1") {
                                    return aggregatedValue + 1;
                                }

                                return aggregatedValue;
                            }
                          },
                          { 'Stage 0':
                            function (aggregatedValue, currentValue) {
                                if (currentValue == "0") {
                                    return aggregatedValue + 1;
                                }

                                return aggregatedValue;
                            }
                          },
                          { 'Stage 1':
                            function (aggregatedValue, currentValue) {
                                if (currentValue == "1") {
                                    return aggregatedValue + 1;
                                }

                                return aggregatedValue;
                            }
                          },
                          { 'Stage 2':
                            function (aggregatedValue, currentValue) {
                                if (currentValue == "2") {
                                    return aggregatedValue + 1;
                                }

                                return aggregatedValue;
                            }
                          }
                      ],
                      aggregatesrenderer: function (aggregates) {
                      var stage = aggregates['Stage -1'];
                      var stage0 = aggregates['Stage 0'];
                      var stage1 = aggregates['Stage 1'];
                      var stage2 = aggregates['Stage 2'];
                      $("#stageAggregateContainer").text(stage);
                      $("#stage0AggregateContainer").text(stage0);
                      $("#stage1AggregateContainer").text(stage1);
                      $("#stage2AggregateContainer").text(stage2);
                    } 

                }
            ],

        }); 

    //onclick grid trigger

    $("#schoolGrid").bind('rowselect', function (event) {
        console.log(event.args.row);
        formUpdate.edit = true;
        formUpdate.schoolId = event.args.row.id; 
        gridUpdate.editData();
        $("[name='comments']").val('');
        $("#myModalLabel").text("Edit Details/Sales By "+event.args.row.name);
        setTimeout(function () {
                        $("#schoolGrid").jqxGrid('clearselection');
                    }, 10);
    });


   
});



var formUpdate = {
        edit: false,
        schoolId: false,
        save: function()
        {
        try{
               var poc = $("[name='pointOfContact']").val();
                if( ! $("[name='schoolName']").val())
                    throw { msg : "Please Enter Schoolname" , elem : "[name='schoolName']"}
                if( ! $("[name='streetAddress']").val())
                    throw { msg : "Please Enter Street Adress" , elem : "[name='streetAddress']"}
                if( ! $("[name='cityName']").val())
                    throw { msg : "Please Enter City Name" , elem : "[name='cityName']"}
                if( ! $("[name='zipCode']").val() || ! $.isNumeric($("[name='zipCode']").val()) || ! ($("[name='zipCode']").val().length == 6))
                    throw { msg : "Please Enter Valid zip code" , elem : "[name='zipCode']"}
                if( ! $("[name='schoolBoard']:checked").val())
                    throw { msg : "Please Select School Board" , elem : "[name='schoolBoard']"}
                if( ! $("[name='noOfStudents']").val() || ! $.isNumeric($("[name='noOfStudents']").val()))
                    throw { msg : "Please Enter Valid No of students" , elem : "[name='noOfStudents']"}
                if( ! $("[name='priceQuoted']").val() || ! $.isNumeric($("[name='priceQuoted']").val()))
                    throw { msg : "Please Enter Valid Price Quoted" , elem : "[name='priceQuoted']"}                            
                if( ! poc)
                    throw { msg : "Please Select Point of contact" , elem : "[name='pointOfContact']"}
                if(poc=='other' && ! $("[name='poinOfContactOthers']").val())
                    throw { msg : "Please Enter Other Point of Contact's Occupation" , elem : "[name='"+poc+"Name']"}
                if( ! $("[name='"+poc+"Name']").val())
                    throw { msg : "Please Enter Point of Contact's Name" , elem : "[name='"+poc+"Name']"}
                if( ! $("[name='"+poc+"PhoneNo']").val())
                    throw { msg : "Please Enter Point of Contact's Phone number" , elem : "[name='"+poc+"PhoneNo']"}
                if( ! $("[name='"+poc+"EMail']").val())
                    throw { msg : "Please Enter Point of Contact's E-mail Id" , elem : "[name='"+poc+"EMail']"}                            
                if( ! $("[name='dateMet']").val())
                    throw { msg : "Please Select Date met" , elem : "[name='dateMet']"}            


            }
            catch(e){
                console.log(e);
                alert(e.msg);
                setTimeout(function(){$(e.elem).focus()},0);
                return;
            }
        
        var formData = $("[name='detailForm']").serializeArray();
        formData.push({name: 'action', value: 'update_school_detail'});
        if(formUpdate.edit && formUpdate.schoolId)
        {
            formData.push({name: 'edit', value: formUpdate.edit});
            formData.push({name: 'school_detail_id', value: formUpdate.schoolId});
        }
        console.log(formData);
        $.ajax({ 
             url: 'server/',
             data: formData,
             type: 'post', 
             dataType: 'json',        
             success: function(data) {
                    if(data['error']==0)
                    {
                        alert(data['message']);
                        $('#detailModal').modal('hide'); 
                        source.localdata = gridUpdate.getData();
                        dataAdapter.dataBind();
                        

                    }
                    else
                        alert(data['message']);
                          
                }
        });
    }
}


var gridUpdate = {
        getData: function()
        {
            var grid_data;
            $.ajax({ 
             url: 'server/',
             async: false,
             data: {action: 'fetch_data'},
             dataType: 'json',
             type: 'post',                  
             success: function(data) {
                    
                    grid_data = data;
                          
                }
            });

            return grid_data;
            
        },
        editData: function()
        {
            $.ajax({ 
             url: 'server/',
             async: false,
             data: {
                    action: 'fetch_full_data',
                    school_detail_id: formUpdate.schoolId
                    },
             dataType: 'json',
             type: 'post',                  
             success: function(data) {
                    $('#comments_container').empty();
                    var comments_to_be_appended = '';
                    console.log(data);

                    $("[name='schoolName']").val(data['school_data']['school_name']);
                    $("[name='streetAddress']").val(data['school_data']['address']);
                    $("[name='cityName']").val(data['school_data']['city']);
                    $("[name='zipCode']").val(data['school_data']['zipcode']);
                    $("[name='schoolBoard'][value='"+data['school_data']['boardname']+"']").prop('checked', true);
                    $("[name='noOfStudents']").val(data['school_data']['no_of_students']).change();
                    $("[name='priceQuoted']").val(data['school_data']['price_quoted']).change();
                    $("[name='pointOfContact']").val(data['school_data']['poc']).change();
                    $("[name='poinOfContactOthers']").val(data['school_data']['others']);
                    $("[name='principalName']").val(data['school_data']['principal_name']);
                    $("[name='principalPhoneNo']").val(data['school_data']['principal_phone_no']);
                    $("[name='principalEMail']").val(data['school_data']['principal_email_id']);
                    $("[name='corresspondentName']").val(data['school_data']['corresspondent_name']);
                    $("[name='corresspondentPhoneNo']").val(data['school_data']['corresspondent_phone_no']);
                    $("[name='corresspondentEMail']").val(data['school_data']['corresspondent_email_id']);
                    $("[name='adminName']").val(data['school_data']['admin_name']);
                    $("[name='adminPhoneNo']").val(data['school_data']['admin_phone_no']);
                    $("[name='adminEMail']").val(data['school_data']['admin_email_id']);
                    $("[name='othersName']").val(data['school_data']['others_name']);
                    $("[name='othersPhoneNo']").val(data['school_data']['others_phone_no']);
                    $("[name='othersEMail']").val(data['school_data']['others_email_id']);
                    $("[name='dateMet']").val(data['school_data']['date_met']);
                    $("[name='stage']").val(data['school_data']['stage']);
                    $("[name='nextFollowupDate']").val(data['school_data']['follow_up_date']);
                    $("[name='noOfStudents'],[name='priceQuoted']").trigger('change');
                    $("#lastUpdatedBlock").html("This data was last updated on <i>"+data['school_data']['last_update_time']+"</i>");
                    $.each(data['comments'],function(key,value){
                        name=value["name"];
                        time=value["last_updated_time"];
                        comment=value["comments"];
                        
                        comments_to_be_appended += '<strong class="pull-left primary-font">'+name+' said . . .</strong><small class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>'+time+'</small></br><li class="ui-state-default">'+comment+'</li></br>'
                        
                    });
                    $('#comments_container').append(comments_to_be_appended);
                    $('#detailModal').modal('show'); 

                    
                    
                          
                }
            });
        }
    };

