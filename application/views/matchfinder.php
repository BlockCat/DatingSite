<div id="main"> 
	<div class="wrapper">
		<div class="flashy_wrapper">

			<h1>Find your perfect partner!</h1>
			<?php if ($this->session->userdata('loggedIn')) { ?>
				<div id="mylinks">
					<a href="<?php echo site_url('matching?mode=1')?>"><button>My likes</button></a>
					<a href="<?php echo site_url('matching?mode=2')?>"><button>Who likes me</button></a>
					<a href="<?php echo site_url('matching?mode=3')?>"><button>Mutual likes</button></a>
				</div>
			<?php }?>
			<div>

				<div id="profileviewer">
					<div class="profile">
						<div class="profilethumbnail">
							<a id="link0"><img id="profilepic0" alt="profilepicture" height="150" width="150"></a>
						</div>
						<div class="profileinfo">
						<a id="nicknameprofile0"></a>
						<p id="sexprofile0"></p>
						<p id="ageprofile0"></p>
						<p id="personalityprofile0"></p>
						<p id="brandsprofile0"></p>
						<p id="descriptionprofile0"></p>
						</div>
					</div>
					<div class="profile">
						<div class="profilethumbnail">
							<a id="link1"><img id="profilepic1" alt="profilepicture" height="150" width="150"></a>
						</div>
						<div class="profileinfo">
						<a id="nicknameprofile1"></a>
						<p id="sexprofile1"></p>
						<p id="ageprofile1"></p>
						<p id="personalityprofile1"></p>
						<p id="brandsprofile1"></p>
						<p id="descriptionprofile1"></p>
						</div>
					</div>
					<div class="profile">
						<div class="profilethumbnail">
							<a id="link2"><img id="profilepic2" alt="profilepicture" height="150" width="150"></a>
						</div>
						<div class="profileinfo">
						<a id="nicknameprofile2"></a>
						<p id="sexprofile2"></p>
						<p id="ageprofile2"></p>
						<p id="personalityprofile2"></p>
						<p id="brandsprofile2"></p>
						<p id="descriptionprofile2"></p>
						</div>
					</div>
					<div class="profile">
						<div class="profilethumbnail">
							<a id="link3"><img id="profilepic3" alt="profilepicture" height="150" width="150"></a>
						</div>
						<div class="profileinfo">
						<a id="nicknameprofile3"></a>
						<p id="sexprofile3"></p>
						<p id="ageprofile3"></p>
						<p id="personalityprofile3"></p>
						<p id="brandsprofile3"></p>
						<p id="descriptionprofile3"></p>
						</div>
					</div>
					<div class="profile">
						<div class="profilethumbnail">
							<a id="link4"><img id="profilepic4" alt="profilepicture" height="150" width="150"></a>
						</div>
						<div class="profileinfo">
						<a id="nicknameprofile4"></a>
						<p id="sexprofile4"></p>
						<p id="ageprofile4"></p>
						<p id="personalityprofile4"></p>
						<p id="brandsprofile4"></p>
						<p id="descriptionprofile4"></p>
						</div>
					</div>
					<div class="profile">
						<div class="profilethumbnail">
							<a id="link5"><img id="profilepic5" alt="profilepicture" height="150" width="150"></a>
						</div>
						<div class="profileinfo">
						<a id="nicknameprofile5"></a>
						<p id="sexprofile5"></p>
						<p id="ageprofile5"></p>
						<p id="personalityprofile5"></p>
						<p id="brandsprofile5"></p>
						<p id="descriptionprofile5"></p>
						</div>
					</div>
				</div>
			</div>
			<button id="refresh">more</button>
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
		setprofiles();		
	});
	
	document.getElementById("refresh").addEventListener("click", function(){
		setprofiles();
	});
	
	function setprofiles(){
		$.get("<?php echo site_url()?>/randomprofile", function (profiles){
			profiledata = profiles;//JSON.parse(profiles);
			for (let nr = 0; nr < 6; nr++) {

				//should be changed in thumbnail location
				console.log(profiledata[nr].brands[0]);
				$("#profilepic"+ String(nr)).attr("src", profiledata[nr].image);
				$("#link" + String(nr)).attr("href", "./profilepage?ID=" + profiledata[nr].userID);
				$("#nicknameprofile" + String(nr)).html(profiledata[nr].userNickname);
				$("#nicknameprofile" + String(nr)).attr("href", "./profilepage?ID=" + profiledata[nr].userID);
				$("#sexprofile" + String(nr)).html(profiledata[nr].userSex);
				$("#ageprofile" + String(nr)).html(getAge(profiledata[nr].userBirthdate));
				$("#personalityprofile" + String(nr)).html(getpersonality(profiledata[nr].personality[0]));
				$("#brandsprofile" + String(nr)).html(getbrands(profiledata[nr].brands));
				$("#descriptionprofile" + String(nr)).html(profiledata[nr].userDescription.substr(0,10) + '...' );

				//like feedback
				<?php if(isset($_SESSION['loggedIn'])){ ?>
						console.log(profiledata[nr].userlikes);
						$("#profilepic"+ String(nr)).css('border-style', 'solid');
						$("#profilepic"+ String(nr)).css('border-width', '0.3em');

						if(profiledata[nr].userlikes == "n"){
							$("#profilepic"+ String(nr)).css('border-color', '#990000');
						}
						else if(profiledata[nr].userlikes  == "r"){
							$("#profilepic"+ String(nr)).css('border-color', '#009933');
						}
						else if(profiledata[nr].userlikes  == "g"){
							$("#profilepic"+ String(nr)).css('border-color', '#0033cc');
						}
				<?php } ?>
			}
		});
	}
	
	function getbrands(brands){
		brandresult = '';
		branddata = brands;
		console.log(brands);
		for (index = 0; index < branddata.length; index++) {
			brandresult += branddata[index].brand + ', ';
		}
		brandresult = brandresult.substr(0,17) + '..'; 
		return brandresult;
	}
	
	function getpersonality(personalitydata) {
		//console.log(personalitydata);
		result = '';
		person = personalitydata;
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