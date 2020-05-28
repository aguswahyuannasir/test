<!-- You have new invitation. Click link below to confirm your invitation<br>
<a href="<?= $link ?>" target="_blank">Click Here</a> -->

<!DOCTYPE html>
<html lang="en">
	<body>
		<div style="border:1px solid #ccc;width:600px;font-family:arial;font-size:14px;margin:auto;">
			<header style="border-bottom:2px solid #2f5be7;padding:10px 20px;">
			</header>
			<div style="padding:10px 20px;">
				<table width="100%">
					<tr>
						<td><h2 style="margin: 0px;">INVITATION MEMBER</h2></td>
					</tr>
					<tr>
						<td style=""><h4>You have invited to one of organization from <?= $owner_name->fullname; ?>, Login to check it out.!</h4></td>
					</tr>
					<tr>
						<td style="text-align: center;">
							<a href="<?= base_url() ?>" target="_blank" style="font-size: 14px; padding: 6px 12px; margin-bottom: 0; background-color: #2ecc71; border: 1px solid transparent; color: #fff; text-decoration: none;">Login</a>
						</td>
					</tr>
				</table>
				<br>
				<br>
			</div>
			<!-- <footer style="border-top:1px solid #ccc;padding:10px 20px;">
				
			</footer> -->
			<div style="padding:10px 20px;background:#f7f7f7;border-top:1px solid #ccc;text-align:right">
				<div style="float:left;width:60%;font-size:11px;text-align:left">
					<!-- <p>Jika butuh bantuan, gunakan halaman <a href="">Kontak Kami</a>. --><br/><?php echo date("Y");?> &copy; test</p>
				</div>
				<div style="clear:both;height:10px"></div>
			</div>
		</div>
	</body>
</html>
