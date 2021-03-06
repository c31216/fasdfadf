$(document).ready(function(){

	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();

	var output = d.getFullYear() + '-' +
	    ((''+month).length<2 ? '0' : '') + month + '-' +
	    ((''+day).length<2 ? '0' : '') + day;

	var clicked_addrecord;
	var addrecord = $("#add-record");
	addrecord.click(function(e){
		e.preventDefault();
		clicked_addrecord = true;
		$("#p_list").prepend('<tr id="active"><td><input type="text" name="patient_registration_date" value="'+output+'" data-toggle="datepicker" class="col-xs-12" ></input></td>'+
								'<td><input type="text" name="patient_bdate" data-toggle="datepicker" value="'+output+'" id="daterange" class="col-xs-12 docs-date"></input></td>'+
								'<td><input type="text" name="patient_lname" class="col-xs-12"></input></td>'+
								'<td><input type="text" name="patient_fname" class="col-xs-12""></input></td>'+
								'<td><input type="number" name="patient_weight" value="0" class="col-xs-12"></input></td>'+
								'<td><input type="number" name="patient_height" value="0" class="col-xs-12"></input></td>'+
								'<td><input type="number" name="patient_headcircumference" value="0" class="col-xs-12"></input></td>'+
								'<td><input type="number" name="patient_age" value="0" class="col-xs-12"></input></td>'+
								'<td><select maxlength="1" name="patient_sex"><option value="M" >M</option><option value="F" >F</option></select></td>'+
								'<td><input type="text" name="patient_mother_name" class="col-xs-12"></input></td>'+
								'<td><input type="text" name="patient_father_name" class="col-xs-12"></input></td>'+
								'<td><input type="text" name="patient_guardian_name" class="col-xs-12"></input></td>'+
								'<td><input type="text" name="patient_address" class="col-xs-12"></input></td>'+
								'<td id="hidden"><input type="text" name="patient_uname" class="col-xs-12"></input></td>'+
								'<td id="hidden"><input type="text" name="patient_pass" class="col-xs-12"></input></td>'+ csrf+
							'</tr>');
		event.stopPropagation();
		$("tr#active td input[name=patient_lname]").focus();
		addrecord.hide();
	  	$('[data-toggle="datepicker"]').datepicker({
	  		format: 'yyyy-mm-dd'
	  	});

	  	$("#th").append('<th id="temporary">Username</th><th id="temporary">Password</th>');

	  	$('#active input').keypress(function(event){

		  if(event.keyCode == 13){

		  	var valid_lic_num = /^(?=.{6,255}$)[a-zA-Z0-9]+(?:_[a-zA-Z0-9]+)*$/;
		    var raw_patient_uname =  $("input[name=patient_uname]").val();
		    var raw_patient_pass =  $("input[name=patient_pass]").val();
		 	
		   

		    var patient_uname = $("input[name=patient_uname]").val();
			var patient_pass = $("input[name=patient_pass]").val();

			

		    patient_bdate = $("input[name=patient_bdate]").val();
			var patient_lname = $("input[name=patient_lname]").val();
			var patient_fname = $("input[name=patient_fname]").val();
			var patient_weight = $("input[name=patient_weight]").val();
			var patient_height = $("input[name=patient_height]").val();
			var patient_headcircumference = $("input[name=patient_headcircumference]").val();
			var patient_age = $("input[name=patient_age]").val();
			var patient_sex = $("select[name=patient_sex]").val();
			var patient_mother_name = $("input[name=patient_mother_name]").val();
			var patient_father_name = $("input[name=patient_father_name]").val();
			var patient_guardian_name = $("input[name=patient_guardian_name]").val();
			var patient_address = $("input[name=patient_address]").val();
			var patient_registration_date = $("input[name=patient_registration_date]").val();

			var patient_bdate = patient_bdate.replace(/\//g, "-");
			var dateAr = patient_bdate.split('-');
			var patient_bdate = dateAr[0] + '-' + dateAr[1] + '-' + dateAr[2].slice(-2);


			$.ajax({
	          type: 'POST',
	          url: add,
	          data: {patient_father_name:patient_father_name,patient_guardian_name:patient_guardian_name,patient_headcircumference:patient_headcircumference,patient_uname:patient_uname,patient_pass:patient_pass,patient_registration_date:patient_registration_date,patient_bdate:patient_bdate,patient_lname:patient_lname,patient_fname:patient_fname,patient_weight:patient_weight,patient_height:patient_height,patient_age:patient_age,patient_sex:patient_sex,patient_mother_name:patient_mother_name,patient_address:patient_address,_token:token},
	          success: function(data){

	        

	         	if (data.patient_id) {
		          	$("input[name=patient_pass]").remove();// remove the value of input upon submisiso
		          	$("input[name=patient_uname]").remove();// remove the value of input upon submisiso


		          	//Add an edit class to all input elements except the specified input attribute name
		          	$( "input[name!='patient_registration_date'][name!='patient_bdate']").closest('td').addClass('edit');

		          	$("input[name='patient_registration_date']").closest("td").addClass("date");
		          	$("input[name='patient_bdate']").closest("td").addClass("date");

		          	$("select[name='patient_sex']").closest("td").addClass("select");

		          	$("tr#active td input").each(function(){
		          		$(this).closest('td').append($(this).val()).addClass($(this).attr('name')).attr('id', data.patient_id);
		          	});// append the input element values to the td element

		          	$("tr#active td select").each(function(){
		          		$(this).closest('td').append($(this).val()).addClass($(this).attr('name')).attr('id', data.patient_id);
		          	});// append the select element value to the td element

		          	$("tr#active").addClass('success');// add class success to table row
		          	$("tr#active td input").remove();// remove the element input upon submisison
		          	$("tr#active td select").remove();// remove the element select upon submisison
		          	$( "tr#active #hidden" ).each(function() {
					  $( this ).remove();
					});
					$( "tr #hidden" ).each(function() {
					  $( this ).remove();
					});
					$("#temporary").remove();
					$("#temporary").remove();

		          	
		          	$("tr#active").append('<td><a href="posts/'+data.patient_id+'"><p>View Profile</p></a></td>'+
		          						  '<td><a href="checkup/'+data.patient_id+'"><p>Check Up</p></a></td>'+
		          						  '<td><a href="immunization/'+data.patient_id+'"><p>Immunization</p></a></td>'+
		          						  '<td><a href="pdf/'+data.patient_id+'" target="_blank"><p>Download PDF</p></a></td>'
		          						  );
		          	$("tr#active").removeAttr("id");
		          	addrecord.show();
		          	clicked_addrecord = false;
	          	}else{

	          		$("#validation").show();
	          		$("#validation strong").html('Failed: ' + data.input + '<br>');
	          		$('tr td input').filter(function() {
					    return !this.value;
					}).attr("placeholder", "Required").addClass("required");
					
				 	if (!valid_lic_num.test(raw_patient_uname)) {  
						$("input[name=patient_uname]").addClass("required");
			    	} 

			    	if (!valid_lic_num.test(raw_patient_pass)) {  
						$("input[name=patient_pass]").addClass("required");
			    	}
			    }
	          }
	           
	        });
		  }
		});


	});	
	
	$(window).click(function(e)
	{
		if (clicked_addrecord) {

			if ( e.target.nodeName=="INPUT" || e.target.nodeName=="SELECT") {
			    return;
			}
			$("tr#active").remove();

			$("#temporary").remove();
			$("#temporary").remove();
			addrecord.show();
       	}
	});
});