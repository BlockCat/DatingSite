<div id="main"> 
	<div class="wrapper">
		<div class="flashy_wrapper">
			<h1>Find your perfect partner!</h1>	
			<div id="profileviewer">
				<div class="profile">
					<div class="profilethumbnail">
					</div>
					<div class="profileinfo">
					<p id="nicknameprofile0"></p>
					<p id="sexprofile0"></p>
					<p id="ageprofile0"></p>
					<p id="personalityprofile0"></p>
					<p id="brandsprofile0"></p>
					<p id="descriptionprofile0"></p>
					</div>
				</div>
				<div class="profile">
					<div class="profilethumbnail">
					</div>
					<div class="profileinfo">
					<p id="nicknameprofile1"></p>
					<p id="sexprofile1"></p>
					<p id="ageprofile1"></p>
					<p id="personalityprofile1"></p>
					<p id="brandsprofile1"></p>
					<p id="descriptionprofile1"></p>
					</div>
				</div>
				<div class="profile">
					<div class="profilethumbnail">
					</div>
					<div class="profileinfo">
					<p id="nicknameprofile2"></p>
					<p id="sexprofile2"></p>
					<p id="ageprofile2"></p>
					<p id="personalityprofile2"></p>
					<p id="brandsprofile2"></p>
					<p id="descriptionprofile2"></p>
					</div>
				</div>
				<div class="profile">
					<div class="profilethumbnail">
					</div>
					<div class="profileinfo">
					<p id="nicknameprofile3"></p>
					<p id="sexprofile3"></p>
					<p id="ageprofile3"></p>
					<p id="personalityprofile3"></p>
					<p id="brandsprofile3"></p>
					<p id="descriptionprofile3"></p>
					</div>
				</div>
				<div class="profile">
					<div class="profilethumbnail">
					</div>
					<div class="profileinfo">
					<p id="nicknameprofile4"></p>
					<p id="sexprofile4"></p>
					<p id="ageprofile4"></p>
					<p id="personalityprofile4"></p>
					<p id="brandsprofile4"></p>
					<p id="descriptionprofile4"></p>
					</div>
				</div>
				<div class="profile">
					<div class="profilethumbnail">
					</div>
					<div class="profileinfo">
					<p id="nicknameprofile5"></p>
					<p id="sexprofile5"></p>
					<p id="ageprofile5"></p>
					<p id="personalityprofile5"></p>
					<p id="brandsprofile5"></p>
					<p id="descriptionprofile5"></p>
					</div>
				</div>
			</div>
			<?php 
			if(!isset($_SESSION['loggedIn'])){
				echo "<h3><a href='register'>Go to our exclusive test here to find your soul partner &#8594;</a></h3>";
			}
			?>
		</div>			
	</div>
</div>
<script>
	$(document).ready(function () {
		$.get("./randomprofile", function (profiles){
			console.log(profiles);
			profiledata = JSON.parse(profiles);	
			for (let nr = 0; nr < 6; nr++) {
				$.get("./profilebrand", {'ID': profiledata[nr].userID}, function (brands){	
					$.get("./profilepersonality", {'ID': profiledata[nr].userPersonality}, function (personalitytype){
						console.log(nr);
						$("#nicknameprofile" + String(nr)).html(profiledata[nr].userNickname);
						$("#sexprofile" + String(nr)).html(profiledata[nr].userSex);
						$("#ageprofile" + String(nr)).html(getAge(profiledata[nr].userBirthdate));
						$("#personalityprofile" + String(nr)).html(getpersonality(personalitytype));
						$("#brandsprofile" + String(nr)).html(getbrands(brands));
						$("#descriptionprofile" + String(nr)).html(profiledata[nr].userDescription.substr(0,10) + '...' );
					});	
				});
			}
		});
	});
	
	function getbrands(brands){
		brandresult = '';
		branddata = JSON.parse(brands);
		for (index = 0; index < branddata.length; index++) {
			brandresult += branddata[index].brand + ', ';
		}
		brandresult = brandresult.substr(0,17) + '..'; 
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