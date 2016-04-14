<div id="main"> 
	<div class="wrapper">
		<div class="text_wrapper">
			<div class="profileinfo">
				<img id="profilepic" alt="profilepicture" height="400" width="400">
				<br>
				<?php if(isset($_SESSION['loggedIn'])){?>
					<?php if($_SESSION['userID'] == $userdata['userID']){?>
						<!--if the profile is our own account-->
						<label class="forlabel">Nickname:</label>
						<input class="attribute" type="text" id="nicknameprofile">
						<br>
						<label class="forlabel">Firstname:</label>
						<input class="attribute" type="text" id="firstnameprofile">
						<br>
						<label class="forlabel">Lastname:</label>
						<input class="attribute" type="text" id="lastnameprofile">
						<br>
						<label class="forlabel">Personality:</label>
						<p class="attribute" id="personalityprofile"></p>
						<br>
						<label class="forlabel">Personality pref:</label>
						<p class="attribute" id="personalitypref"></p>
						<br>
						<label class="forlabel">Sex:</label>
						<input class="attribute" type="text" id="sexprofile">
						<br>
						<label class="forlabel">Date of birth:</label>
						<input class="attribute" type="text" id="ageprofile">
						<br>
						<label class="forlabel">Sexual pref:</label>
						<input class="attribute" type="text" id="sexpref">
						<br>
						<label class="forlabel">Minimal age pref:</label>
						<input class="attribute" type="text" id="minagepref">
						<br>
						<label class="forlabel">Maximium age pref:</label>
						<input class="attribute" type="text" id="maxagepref">
						<br>
						<label class="forlabel">Description:</label>
						<input class="attribute" type="text" id="descriptionprofile">
						<br>
						<label class="forlabel">Brands:</label>
						<input class="attribute" type="text" id="brandsprofile">
						<br>
						<label class="forlabel">Email:</label>
						<input class="attribute" type="text" id="emailprofile">
						<br>
						<label class="forlabel">password:</label>
						<input class="attribute" type="text" id="passwordprofile">
						<br>
						<input type="submit" name="submit">
					<?php }else{?>
						<!--is different from the list below this one, because this one should also contain email & name if there is a mutual like-->
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
			<?php if($_SESSION['userID'] == $userdata['userID']){?>
				setuser();
			<?php }else{?>
				setprofile();
			<?php } ?>			
		<?php }else{?>
			setprofile();
		<?php } ?>
	});
	
	
	function setuser(){
		$.get("./profilebrand", {'ID': <?php echo $userdata['userID']?>}, function (brands){	
			$.get("./profilepersonality", {'ID': <?php echo $userdata['userPersonality']?>}, function (personalitytype){
				$.get("./profilepersonality", {'ID': <?php echo $userdata['userPersonalityPref']?>}, function (personalitypref){				
					<?php if(isset($_SESSION['loggedIn'])){?>
							$("#profilepic").attr("src", "./images/profilepic/<?php echo $userdata["userID"]?>.jpg")					
					<?php }else{?>
							$("#profilepic").attr("src", "./images/profilepic/<?php echo $userdata["userSex"]?>silhoutte.jpg")					
					<?php } ?>
					$("#nicknameprofile").attr('value', '<?php echo $userdata['userNickname']?>');
					$("#firstnameprofile").attr('value', '<?php echo $userdata['userFirstName']?>');
					$("#lastnameprofile").attr('value', '<?php echo $userdata['userLastName']?>');
					$("#sexprofile").attr('value','<?php echo $userdata['userSex']?>');
					$("#ageprofile").attr('value','<?php echo $userdata['userBirthdate']?>');
					$("#personalityprofile").html(getpersonality(personalitytype));
					$("#sexpref").attr('value','<?php echo $userdata['userSexPref']?>');
					$("#personalitypref").html(getpersonality(personalitypref));
					$("#brandsprofile").attr('value',getbrands(brands));
					$("#descriptionprofile").attr('value','<?php echo $userdata['userDescription']?>');
					$("#minagepref").attr('value','<?php echo $userdata['userMinAgePref']?>');
					$("#maxagepref").attr('value','<?php echo $userdata['userMaxAgePref']?>');
					$("#emailprofile").attr('value','<?php echo $userdata['userEmail']?>');
					$("#passwordprofile").attr('placeholder', 'new password');
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