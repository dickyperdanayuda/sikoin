<style>
.brPic {
  border-radius: 8px;  
}
.cardPic {
  border: 2px solid #fff;
  box-shadow:0px 0px 10px 0 #a9a9a9;
  padding: 5px 5px;
  width: 100%;
  // margin: 50px auto;
}
.wrapperPic {
  width: 0px;
  animation: fullView 0.5s forwards cubic-bezier(0.250, 0.460, 0.450, 0.940);
}
.profilePic {
  height: 200px;
  width: 100%;
  // border-radius: 50%;
}
@keyframes fullView {
  100% {
    width: 100%;
  }
}


.animatePic {
   animation : shimmer 2s infinite linear;
   background: linear-gradient(to right, #eff1f3 4%, #e2e2e2 25%, #eff1f3 36%);
    background-size: 1000px 100%;
}

@keyframes shimmer {
  0% {
    background-position: -1000px 0;
  }
  100% {
    background-position: 1000px 0;
  }
}
</style>
<div class="col-lg-3 col-md-4 mt-3 loadPic" id="loadPic1">
	<div class="cardPic brPic">
	   <div class="wrapperPic">
		  <div class="profilePic animatePic din"></div>
	   </div>
	</div>
</div>
<div class="col-lg-3 col-md-4 mt-3 loadPic" id="loadPic2">
	<div class="cardPic brPic">
	   <div class="wrapperPic">
		  <div class="profilePic animatePic din"></div>
	   </div>
	</div>
</div>
<div class="col-lg-3 col-md-4 mt-3 loadPic" id="loadPic3">
	<div class="cardPic brPic">
	   <div class="wrapperPic">
		  <div class="profilePic animatePic din"></div>
	   </div>
	</div>
</div>

<?php 
foreach($data as $dt) { 
	if ($dt->ft_link) {
?>
	<div class="col-lg-3 col-md-4 mt-3">
		<a href="<?=$dt->ft_link;?>" target="_blank">
			<div class="cardPic brPic">
				<div class="wrapperPic">
					<div class="profilePic" style="background-image:url('<?=str_replace("donatur/","donatur/thumbs/",$dt->ft_link);?>');background-size:contain;background-repeat:no-repeat;background-position:center;"></div>
				</div>
			</div>
		</a>
		<center><?=$dt->ft_nama;?><br><span class=""><a class="text-danger" href="#" onClick="hapus_ft(<?=$dt->ft_id;?>,<?=$dt->ft_don_id;?>)"><i class="fa fa-trash"></i></a></span></center>
	</div>
	<?php }
} ?>
<script>

function hapus_ft(id,don_id)
{
	let hapus = confirm("Yakin ingin menghapus foto ini ?");
	if (hapus)
	{
		$.ajax({
			type: "GET",
			url: "hapus_foto/" + id,
			success: function (d) {
				$("#frm_galery").trigger("reset");
				$.get("show_galery/"+don_id,{},function(data) {
					$("#isi_galery").html(data);
					return false;
				});
			},
			error: function (jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}
}
$(document).ready(function() {
	$(".loadPic").hide();
});

</script>