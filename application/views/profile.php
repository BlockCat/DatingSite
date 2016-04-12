<div id="main"> 
	<div class="wrapper">
		<div class="flashy_wrapper">
			<div class="profileinfo">
				<p id="nicknameprofile"></p>
				<p id="sexprofile"></p>
				<p id="ageprofile"></p>
				<p id="personalityprofile"></p>
				<p id="brandsprofile"></p>
				<p id="descriptionprofile"></p>
			</div>
		</div>			
	</div>
</div>
<script>
	$(document).ready(function () {
		$.get("./profilebrand", {'ID': <?php echo $userdata['userID']?>}, function (brands){	
			$.get("./profilepersonality", {'ID': <?php echo $userdata['userPersonality']?>}, function (personalitytype){
				$("#nicknameprofile").html('<?php echo $userdata['userNickname']?>');
				$("#sexprofile").html('<?php echo $userdata['userSex']?>');
				$("#ageprofile").html(getAge('<?php echo $userdata['userBirthdate']?>'));
				$("#personalityprofile").html(getpersonality(personalitytype));
				$("#brandsprofile").html(getbrands(brands));
				$("#descriptionprofile").html('<?php echo $userdata['userDescription']?>');
			});	
		});	
	});
	
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