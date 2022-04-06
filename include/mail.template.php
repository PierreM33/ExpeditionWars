<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>#title_mail#</title>
	<style>
		@font-face {font-family: 'Agency FB'; src: url('../font/AgencyFB-Reg.eot?#iefix') format('embedded-opentype'), url('../font/AgencyFB-Reg.woff') format('woff'), url('../font/AgencyFB-Reg.ttf')  format('truetype'), url('../font/AgencyFB-Reg.svg#AgencyFB-Reg') format('svg'); src:local('../font/Agency FB'), local('Agency FB'), url('../font/AgencyFB-Reg.woff') format('woff'); font-weight: normal; font-style: normal;}
		body {margin:0;padding:0; font-family:Agency FB, sans-serif;}
		img,table,tr,td {margin:0;display:block;border:none;padding:0;}
		table {width:700px; font-family: Agency FB, sans-serif;}
		.head {background:url(https://expedition-wars.fr/static/img/images_mail/header.jpg) no-repeat; width:700px; height:180px}
		.head_title, .header_scroll, .header_infos {width:700px; height:40px; display:inline-flex;}
		.lt {background:url(https://expedition-wars.fr/static/img/images_mail/left_title.jpg) no-repeat; width:133px; height:40px;}
		.mt {background:url(https://expedition-wars.fr/static/img/images_mail/title.jpg) no-repeat; width:442px; height:40px;color:#ffffff; text-align:center; font-size:20px; font-weight:bold;text-transform:uppercase;font-family:Agency FB;line-height:40px;}
		.rt {background:url(https://expedition-wars.fr/static/img/images_mail/right_title.jpg) no-repeat; width:125px; height:40px;}
		.head_scroll {background:url(https://expedition-wars.fr/static/img/images_mail/head_scroll.jpg) no-repeat; width:700px; height:82px;}
		.header_scroll {height:481px;}
		.ls {background:url(https://expedition-wars.fr/static/img/images_mail/left_scroll.jpg) no-repeat; width:44px; height:481px;}
		.ms {background:url(https://expedition-wars.fr/static/img/images_mail/scroll.jpg) no-repeat; width:619px; height:481px; color:#263239; font-size:16px;}
		.rs {background:url(https://expedition-wars.fr/static/img/images_mail/right_scroll.jpg) no-repeat; width:37px; height:481px;}
		.ms a {color:#59c2ff; text-decoration:none;}
		.ms a:hover {color:#ffffff;}
		.head_infos {background:url(https://expedition-wars.fr/static/img/images_mail/head_infos.jpg) no-repeat; width:700px; height:127px;}
		.header_infos {height:39px;}
		.li {background:url(https://expedition-wars.fr/static/img/images_mail/left_infos.jpg) no-repeat; width:70px; height:39px;}
		.mi {background:url(https://expedition-wars.fr/static/img/images_mail/infos.jpg) no-repeat; width:563px; height:39px;}
		.mi ul {list-style:none;font-size:0;display:inline-flex;}
		.mi ul li {font-size:18px;font-weight:bold;margin-right:10px;}
		.mi ul li a {background:url(https://expedition-wars.fr/static/img/images_mail/small_bt.png) no-repeat; width:158px; height:32px;text-align:center;line-height:32px; text-decoration:none;color:#89d1ff; display:block;font-weight:normal;font-size:18px;}
		.mi ul li a:hover {color:#ffffff;}
		.ri {background:url(https://expedition-wars.fr/static/img/images_mail/right_infos.jpg) no-repeat; width:67px; height:39px;}
		.footer {background:url(https://expedition-wars.fr/static/img/images_mail/footer.jpg) no-repeat; wifth:700px; height:137px}
		a.bt {background:url(https://expedition-wars.fr/static/img/images_mail/bt.png) no-repeat; width:310px; height:53px;text-align:center;line-height:53px; text-decoration:none;color:#89d1ff; display:block;font-weight:normal;font-size:30px;margin:5px auto;}
		a:hover.bt {color:#ffffff;}
	</style>
</head>
<body>
	<table>
		<tr class="head"></tr>
		<tr class="head_title">
			<td class="lt"></td>
			<td class="mt">#titre_mail#</td>
			<td class="rt"></td>
		</tr>
		<tr class="head_scroll"></tr>
		<tr class="header_scroll">
			<td class="ls"></td>
			<td class="ms">#texte_mail#</td>
			<td class="rs"></td>
		</tr>

		<tr class="head_infos"></tr>
		<tr class="footer"></tr>

	</table>
</body>
</html>