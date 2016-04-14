<div id="main"> 
	<div class="wrapper">
		<div class="text_wrapper">
			<div class="profileinfo">
				<img id="profilepic" alt="profilepicture" height="400" width="400">
				<?php if(isset($_SESSION['loggedIn'])){?>
					<input class=""type="text" id="nicknameprofile">
					<input type="text" id="firstnameprofile">
					<input type="text" id="lastnameprofile">
					<p id="personalityprofile"></p>
					<p id="personalitypref"></p>
					<input type="text" id="sexprofile">
					<input type="text" id="ageprofile">
					<input type="text" id="sexpref">
					<input type="text" id="minagepref">
					<input type="text" id="maxagepref">
					<input type="text" id="descriptionprofile">
					<input type="text" id="brandsprofile">
					<input type="text" id="emailprofile">
					<input type="text" id="passwordprofile">
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
			setprofile();
		<?php }else{?>
			setuser();
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
		brandresult = '';
		branddata = JSON.parse(brands);
		for (index = 0; index < branddata.length; index++) {
			brandresult += branddata[index].brand + ', ';
		}
		return brandresult;
	}
	
	function getpersonality(personalitydata) {
		console.log(personalitydata);
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