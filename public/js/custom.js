
		$(document).ready(function () {
			$(".bkngbtn").click(function () {
				$(".frmset").toggleClass('dinblk');
			});
		});

		$(document).ready(function () {
			$(".ysbtn").click(function () {
                // $("#container_yesbtn").show();
                $(".sbmtbtn").toggleClass('dis-none');
                $("#NoSubmitbtn").hide();
            });
		});

		$(document).ready(function () {
			$(".nobtn").click(function () {
				$(".sbmtbtn").toggleClass('dinblk');
                $(".sbmtbtn").removeClass('dis-none');
                $("#NoSubmitbtn").show();
                // $("#container_yesbtn").hide();
            });
		});

        $(document).ready(function () {
            $("#refer_one_more_btn").click(function () {
                $("#first_refer_submit").prop('disabled',true);
                // $("#container_yesbtn").hide();
            });
        });

		// $(".nobtn").click(function(){
		// 	$("#hide").hide();
		// });

		// $(".nobtn").click(function(){
 		// 	 $("#show").show();
		// });


