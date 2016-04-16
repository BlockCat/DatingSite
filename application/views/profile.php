<div id="main"> 
	<div class="wrapper">
		<div class="text_wrapper">
			<div class="profileinfo">
				<img id="profilepic" alt="profilepicture" height="400" width="400">
				<br>
				<?php if(isset($_SESSION['loggedIn'])){?>
					<!--is different from the list below this one, because this one should also contain email & name if there is a mutual like-->
					<button id="like">Like</button>
					<p id="nicknameprofile"></p>
					<p id="firstnameprofile"></p>
					<p id="lastnameprofile"></p>
					<p id="emailprofile"></p>
					<p id="sexprofile"></p>
					<p id="ageprofile"></p>
					<p id="personalityprofile"></p>
					<p id="sexpref"></p>
					<p id="agepref"></p>
					<p id="personalitypref"></p>
					<p id="descriptionprofile"></p>
					<p id="brandsprofile"></p>
				<!--when the user is not logged in-->					
				<?php }else{?>
					<p id="nicknameprofile"></p>
					<p id="sexprofile"></p>
					<p id="ageprofile"></p>
					<p id="personalityprofile"></p>
					<p id="sexpref"></p>
					<p id="agepref"></p>
					<p id="personalitypref"></p>
					<p id="descriptionprofile"></p>
					<p id="brandsprofile"></p>
				<?php } ?>
			</div>
			<?php 
			if(!isset($_SESSION['loggedIn'])){
				echo "<h3><a href='./login'>Login to like this person and get to know him/her better!&#8594;</a></h3>";
			}
			?>
		</div>		
	</div>
</div>
<script>
	$(document).ready(function () {
		<?php if(isset($_SESSION['loggedIn'])){?>
			//this is when we are looking at another profile while we are logged in
			setprofile();
			$.get("./likecheck", {'userID':<?php echo $_SESSION['userID']?>,
			'profileID':<?php echo $userdata['userID']?>}, function (likeRelation){
				console.log(likeRelation);
				//n= none, g= given, r= received, m=mutual
				if(likeRelation == "m"){	
					$("#emailprofile").html('<?php echo $userdata['userEmail']?>');
					$("#firstnameprofile").html('<?php echo $userdata['userFirstName']?>');
					$("#lastnameprofile").html('<?php echo $userdata['userLastName']?>');
				}
				if(likeRelation == "n" || likeRelation == "r"){			
					$("#like").click(function(){
						$.get("./liker", {'userID':<?php echo $_SESSION['userID']?>,
						'profileID':<?php echo $userdata['userID']?>}, function (){
							$("#like").unbind('click');
							$("#like").attr('id', 'liked');
							$("#liked").html('Liked');
						});
					});
				}else{
					$("#like").attr('id', 'liked');
					$("#liked").html('Liked');
				}					
			});
		//this is when we are not logged in
		<?php }else{?>
			setprofile();
		<?php } ?>
		
		
	});
	
	function setprofile(){
		$.get("./profilebrand", {'ID': <?php echo $userdata['userID']?>}, function (brands){	
			$.get("./profilepersonality", {'ID': <?php echo $userdata['userPersonality']?>}, function (personalitytype){
				$.get("./profilepersonality", {'ID': <?php echo $userdata['userPersonalityPref']?>}, function (personalitypref){				
					<?php if(isset($_SESSION['loggedIn'])){?>
							$("#profilepic").attr("src", "./images/profilepic/<?php echo $userdata["userID"]?>.jpg")					
					<?php }else{?>
							$("#profilepic").attr("src", "./images/profilepic/<?php echo $userdata["userSex"]?>silhoutte.jpg")					
					<?php } ?>
					$("#nicknameprofile").html('<?php echo $userdata['userNickname']?>');
					$("#sexprofile").html('<?php echo $userdata['userSex']?>');
					$("#ageprofile").html('<?php echo $userdata['userBirthdate']?>');
					$("#personalityprofile").html(getpersonality(personalitytype));
					$("#sexpref").html('<?php echo $userdata['userSexPref']?>');
					$("#agepref").html('<?php echo $userdata['userMinAgePref'] . " - " . $userdata['userMaxAgePref']?>');
					$("#personalitypref").html(getpersonality(personalitypref));
					$("#brandsprofile").html(getbrands(brands));
					$("#descriptionprofile").html('<?php echo $userdata['userDescription']?>');
				});
			});	
		});
	}
	
	function getbrands(brands){
		branddata = JSON.parse(brands);
		brandresult = branddata[0].brand;
		for (index = 1; index < branddata.length; index++) {
			brandresult += ', ' + branddata[index].brand;
		}
		return brandresult;
	}
	
	function getpersonality(personalitydata) {
		result = '';
		person = JSON.parse(personalitydata)[0];
		if(parseInt(person.e) >= parseInt(person.i)){
			result += 'e';
		}
		else{
			result += 'i';
		}
		if(parseInt(person.n) >= parseInt(person.s)){
			result += 'n';
		}
		else{
			result += 's';
		}
		if(parseInt(person.f) >= parseInt(person.t)){
			result += 'f';
		}
		else{
			result += 't';
		}
		if(parseInt(person.j) >= parseInt(person.p)){
			result += 'j';
		}
		else{
			result += 'p';
		}
		return result;		
	}
	
	function getAge(dateString) {
		var today = new Date();
		var birthDate = new Date(dateString);
		var age = today.getFullYear() - birthDate.getFullYear();
		var m = today.getMonth() - birthDate.getMonth();
		if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
			age--;
		}
		return age;
	}
</script>