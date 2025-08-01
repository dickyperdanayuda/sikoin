var cek = 0;

function autoSize(element) {
	// alert(element.style.height);
	if (parseInt(element.scrollHeight) < 500)
	{
		element.style.height = "1px";
		element.style.height = (10+element.scrollHeight)+"px";		
	}
	else 
	{
		element.style.height = "1px";
		element.style.height = "500px";		
	}
}

function stopSlide() {
	$("#carousel-video-donatur").carousel("pause");
}


function pilih_jenis(val) {
	var nominal = $("#wkf_jmlf").val();
	if (val == 1)
	{
		$("#wkf_jmlf").show();
		if (nominal > 0)
		{			
			$("#wkf_jmlb").prop("required",false);
			$("#wkf_jmlb").hide();
		}
		else 
		{
			$("#wkf_jmlb").prop("required",true);
			$("#wkf_jmlb").show();
		}
	}
	else 
	{
		$("#wkf_jmlf").hide();
		$("#wkf_jmlb").show();
	}
}

function pilih_nominal(val) {
	if (val > 0)
	{			
		$("#wkf_jmlb").prop("required",false);
		$("#wkf_jmlb").hide();
	}
	else 
	{
		$("#wkf_jmlb").prop("required",true);
		$("#wkf_jmlb").show();
	}
}

function tampil_video(src,type)
{
	$("#vu").trigger("pause");
	$("#vid_src").attr("src",src);
	$("#vid_src").attr("type","video/"+type);
	$("#vid_player").load();
	$("#vid_player").trigger("play");
	$('#modal_video').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function empty_video()
{
	$("#vid_src").attr("src","");
	$("#vid_src").attr("type","");
	$("#vid_player").trigger("pause");
	$("#vu").trigger("play");
}

function buka_wakaf()
{
	fbq('track','AddToCart');
	$("#vid_src").attr("src","");
	$("#vid_src").attr("type","");
	$("#vid_player").trigger("pause");
	$("#modal_video").modal("hide");
	setTimeout(function() {
		$("#frmWakaf").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	},100);
}

function isi_an(val)
{
	$("#wkf_atasnama").val(val);
}

function reset_form()
{
	$("#frm_wakaf")[0].reset();
}

function scrollbawah(self,target)
{
    $('#'+self).on('scroll', function() {
        if($(this).scrollTop()== $(this).scrollHeight) {
            alert('end '+target);
        }
	console.log($(this).scrollTop() + $(this).innerHeight());
	console.log($(this).scrollHeight);
    })
}

function cekscroll(ele,target)
{
	if(ele.scrollTop == ele.scrollHeight) {
		alert('end '+target);
	}
}

function tampilForm(id)
{
	if ($("#"+id).is(":checked")) {
		$("#form_transfer").show();
		// $("#don_nama").focus();
	}
	else 
	{
		$("#form_transfer").hide();
	}
}

function cek_wa(wa)
{
	$.get("LandingPage/cek_wa/"+wa,{},function(d){
		cek = d;
	});
}

function titleCase(str) {
   var splitStr = str.toLowerCase().split(' ');
   for (var i = 0; i < splitStr.length; i++) {
       // You do not need to check if i is larger than splitStr length, as your for does that for you
       // Assign it back to the array
       splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
   }
   // Directly return the joined string
   return splitStr.join(' '); 
}

function tutup_info()
{
	setTimeout(function() {
		$("#don_wa").focus();
	},500);
}

$(document).ready(function() {	
	$('.tgl').daterangepicker({
		autoUpdateInput: false,
		locale: {
		  format: 'DD/MM/YYYY'
		},
		showDropdowns: true,
		singleDatePicker: true,
		// autoApply: true,
		// opens: 'left',
		drops: 'up'
	}, function(chosen_date) {
		$('.tgl').val(chosen_date.format('YYYY-MM-DD'))
	});
	
	$("#frm_transfer").submit(function(e){
		e.preventDefault();
		var wa = $("#don_wa").val();
		var jk = $("#don_jk").val();
		var namanya = $("#don_nama").val();
		var datanya = new FormData(this);
		$.get("LandingPage/cek_wa/"+wa,{},function(d){
			if (d == 0)
			{
				$("#don_simpan").html("Menyimpan...");
				$(".btn").attr("disabled", true);
				$.ajax({
				   type: "POST",
					url: "LandingPage/simpan",  
					data: datanya,
					processData: false,
					contentType: false,
					success: function(d) 
					{
						var res = JSON.parse(d);
						if (res.status == 1)
						{
							var sapa = "Bapak";
							if (jk == 2) sapa = "Ibu";
							var nama = titleCase(namanya.toLowerCase());
							$("#sapa").html(sapa+" "+nama);
							$("#form_transfer").hide();
							$("#form_konfirmasi").hide();
							$("#form_berhasil").show();
						}
						else
						{
							toastr.error(res.desc);
						}
						$("#don_simpan").html("Simpan");
						$(".btn").attr("disabled", false);
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						$("#don_simpan").html("Simpan");
						$(".btn").attr("disabled", false);
						toastr.error(res.errorThrown);            
					}
				});
			}
			else 
			{					
				$("#modal_info").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
			}
		});
	});
});