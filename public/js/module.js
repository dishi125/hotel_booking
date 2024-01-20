
var Refreshtoken = '1000.363abc5e60301b1b51b9407b595c4459.4bf1bd86c2c5f1756e7e75d3e10ef9c1';
var Clientid = '1000.SK7FAX5FI50XP8GOWXQVP72AAGHLBW';
var Clientsecret = 'de2ac49424ba45cfb2aefca754e5450211cb0b68a2';
var Granttype = 'refresh_token';
var token;

function funCheckValidate()
{
    var is_valid_values = true;

	if($("#txtphone").val().trim() == '')
	{
		if($("#txtemail").val().trim() == '')
		{
			 	alert('Please enter PHONE NO/EMAIL ID');
	 	        return false;
		}
	}

	var txtphone = "";
	if ($('#txtphone').val()!=""){
        is_valid_values = validate_mobile_no($('#txtphone').val());
        // txtphone = $('#countryCode').val() + $('#txtphone').val();
        txtphone = $('#txtphone').val();
    }

    if($("#txtphone").val().trim() == '')
    {
        if ($('#txtemail').val()!=""){
            is_valid_values = validate_email($('#txtemail').val());
        }
    }

    // console.log("txtphone:",txtphone);

    if (is_valid_values == true) {
        jQuery(document).ready(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                type: 'POST',
                url: "/tocken",
                data: {
                    txtphone: txtphone,
                    txtemail: $('#txtemail').val()
                },

                success: function (data) {
                    //console.log(datafetch.data[0]);
                    //console.log(maindata.Owner.name);
                    console.log(data);
                    var datafetch = jQuery.parseJSON(data);
                    //alert(datafetch.Owner);
                    var maindata = datafetch.data[0];
                    if (maindata.Existing_Customer == true){
                        $("#inputfirstname").val(maindata.First_Name);
                        $("#inputsurname").val(maindata.Last_Name);
                        $("#userid").val(maindata.id);
                        $("#ownerid").val(maindata.Owner.id);
                        $("#owner_name").val(maindata.Owner.name);
                        if (maindata.Salutation != null) {
                            $("#inputttl").val(maindata.Salutation);
                        }
                        $("#bookingModal").toggle();
                    }
                    else{
                        $("#InvalidUserModal").modal('show');
                    }
                }
            });
        });
    }
}

function validate_email(email)
{
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
    {
        return true;
    }
    alert("You have entered an invalid email address!");
    return false;
}

function validate_mobile_no(mobile_no)
{
    if(mobile_no.match('[0-9]{10}') && mobile_no.length == 10)  {
        return true;
    }
    alert("You have entered an invalid Mobile Number!");
    return false;
}


$("#NoSubmitbtn").on('click',function() {
    funAddOffer();
});

function funAddOffer()
{

    jQuery(document).ready(function(){
	$.ajax({
       type:'POST',
       url:"/offer",
       data: {
           userid: jQuery('#userid').val(),
           ownerid: jQuery('#ownerid').val(),
           firstname: jQuery('#inputfirstname').val(),
           surname: jQuery('#inputsurname').val(),
           inputnight: jQuery('#inputnight').val(),
           dropdownMenuLink: $("#dropdownMenuLink option:selected" ).text()
        },

       success:function(data) {
       	//console.log(datafetch.data[0]);
          //console.log(maindata.Owner.name);
          console.log(data);
          location.reload();
          //var datafetch =jQuery.parseJSON(data);
          //alert(datafetch.Owner);
          ///var maindata = datafetch.data[0];



         // $("#inputfirstname").val(maindata.Owner.name);
          //$("#bookingModal").toggle();
       }
    });
	 });
	// write code for validate and if got response then open bookingModal else exampleModal

	// response no
	//$("#exampleModal").modal("show");

	// response yes
	//$("#bookingModal").modal("show");
}

$("#first_refer_submit").on('click',function() {
    $("#first_refer_email_duplicate").html("");
    $("#second_refer_email_duplicate").html("");
    var is_valid_values = true;
    var dataval = '';
    if ($('#first_refer_phoneno').val()!=''){
       dataval = $('#first_refer_phoneno').val();
    }
    else if ($('#first_refer_email').val()!=''){
       dataval = $('#first_refer_email').val();
    }

    if (dataval == ''){
        alert("Please enter Mobile Number or E-mail");
        is_valid_values = false;
        return false;
    }

    var txtphone = "";
    if ($('#first_refer_phoneno').val()!=""){
        is_valid_values = validate_mobile_no($('#first_refer_phoneno').val());
        // txtphone = $('#countryCode').val() + $('#first_refer_phoneno').val();
        txtphone = $('#first_refer_phoneno').val();
    }

    if($("#first_refer_phoneno").val().trim() == '')
    {
        if ($('#first_refer_email').val()!=""){
            is_valid_values = validate_email($('#first_refer_email').val());
        }
    }
    // console.log("txtphone:",txtphone);

    if (is_valid_values == true) {
       $.ajax({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
           type: 'POST',
           url: "/first_refer_submit",
           data: {
               user_id: jQuery('#userid').val(),
               ownerid: jQuery('#ownerid').val(),
               owner_name: jQuery('#owner_name').val(),
               firstname: jQuery('#inputfirstname').val(),
               surname: jQuery('#inputsurname').val(),
               txtphone: txtphone,
               txtemail: jQuery('#first_refer_email').val(),
               first_refer_firstame: jQuery('#first_refer_firstame').val(),
               first_refer_surname: jQuery('#first_refer_surname').val(),
               inputnight: jQuery('#inputnight').val(),
               dropdownMenuLink: $("#dropdownMenuLink option:selected" ).text(),
               Country_Code_Mobile: jQuery('#first_refer_countrycode').val(),
           },

           success: function (data) {
               console.log(data);
               var datafetch = jQuery.parseJSON(data);
               //alert(datafetch.Owner);
               var maindata = datafetch.data[0];
               if (maindata.code == "DUPLICATE_DATA"){
                    $("#first_refer_email_duplicate").html(maindata.message);
               }
               /*$("#first_refer_firstame").val(maindata.First_Name);
               $("#first_refer_surname").val(maindata.Last_Name);
               $("#first_refer_userid").val(maindata.id);
               $("#first_refer_ownerid").val(maindata.Owner.id);*/
           }
       });
    }
});

$("#second_refer_submit").on('click',function() {
    $("#first_refer_email_duplicate").html("");
    $("#second_refer_email_duplicate").html("");
    var is_valid_values1 = true;
    var is_valid_values2 = true;
    var dataval1 = '';
    var dataval2 = '';
    if ($('#first_refer_phoneno').val()!=''){
        dataval1 = $('#first_refer_phoneno').val();
    }
    else if ($('#first_refer_email').val()!=''){
        dataval1 = $('#first_refer_email').val();
    }

    if ($('#second_refer_phoneno').val()!=''){
        dataval2 = $('#second_refer_phoneno').val();
    }
    else if ($('#second_refer_email').val()!=''){
        dataval2 = $('#second_refer_email').val();
    }

    if (dataval1 == '' || dataval2 == ''){
        alert("Please enter Mobile Number or E-mail for both referred users");
        is_valid_values1 = false;
        is_valid_values2 = false;
        return false;
    }

    var txtphone1 = "";
    if ($('#first_refer_phoneno').val()!=""){
        is_valid_values1 = validate_mobile_no($('#first_refer_phoneno').val());
        // txtphone1 = $('#countryCode').val() + $('#first_refer_phoneno').val();
        txtphone1 = $('#first_refer_phoneno').val();
    }

    var txtphone2 = "";
    if ($('#second_refer_phoneno').val()!=""){
        is_valid_values2 = validate_mobile_no($('#second_refer_phoneno').val());
        // txtphone2 = $('#countryCode').val() + $('#second_refer_phoneno').val();
        txtphone2 = $('#second_refer_phoneno').val();
    }

    if($("#first_refer_phoneno").val().trim() == '')
    {
        if ($('#first_refer_email').val()!=""){
            is_valid_values1 = validate_email($('#first_refer_email').val());
        }
    }

    if($("#second_refer_phoneno").val().trim() == '')
    {
        if ($('#second_refer_email').val()!=""){
            is_valid_values2 = validate_email($('#second_refer_email').val());
        }
    }
    // console.log("txtphone1:",txtphone1);
    // console.log("txtphone2:",txtphone2);

    if (dataval1!='' && dataval2!='' && is_valid_values1==true && is_valid_values2==true) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            type: 'POST',
            url: "/second_refer_submit",
            data: {
                user_id: jQuery('#userid').val(),
                ownerid: jQuery('#ownerid').val(),
                owner_name: jQuery('#owner_name').val(),
                firstname: jQuery('#inputfirstname').val(),
                surname: jQuery('#inputsurname').val(),
                txtphone1: txtphone1,
                txtemail1: jQuery('#first_refer_email').val(),
                first_refer_firstame: jQuery('#first_refer_firstame').val(),
                first_refer_surname: jQuery('#first_refer_surname').val(),
                txtphone2: txtphone2,
                txtemail2: jQuery('#second_refer_email').val(),
                second_refer_firstame: jQuery('#second_refer_firstame').val(),
                second_refer_surname: jQuery('#second_refer_surname').val(),
                inputnight: jQuery('#inputnight').val(),
                dropdownMenuLink: $("#dropdownMenuLink option:selected" ).text(),
                Country_Code_Mobile1: jQuery('#first_refer_countrycode').val(),
                Country_Code_Mobile2: jQuery('#second_refer_countrycode').val(),
            },

            success: function (data) {
                console.log(data);
                var datafetch = jQuery.parseJSON(data['leads_data']);
                // console.log("leads_data");
                // console.log(datafetch);
                if (data['leads_data_for'] == "second_refer" && datafetch.data[0].code == "DUPLICATE_DATA"){
                    $("#second_refer_email_duplicate").html(datafetch.data[0].message);
                }
                else if (data['leads_data_for'] == "first_refer" && datafetch.data[0].code == "DUPLICATE_DATA"){
                    $("#first_refer_email_duplicate").html(datafetch.data[0].message);
                }
                else if (data['leads_data_for'] == "both_refer"){
                    if (datafetch.data[0].code == "DUPLICATE_DATA") {
                        $("#first_refer_email_duplicate").html(datafetch.data[0].message);
                    }
                    if (datafetch.data[1].code == "DUPLICATE_DATA") {
                        $("#second_refer_email_duplicate").html(datafetch.data[1].message);
                    }
                }

                // var maindata = datafetch.data[0];

                /*$("#first_refer_firstame").val(maindata.First_Name);
                $("#first_refer_surname").val(maindata.Last_Name);
                $("#first_refer_userid").val(maindata.id);
                $("#first_refer_ownerid").val(maindata.Owner.id);*/
            }
        });
    }
});


