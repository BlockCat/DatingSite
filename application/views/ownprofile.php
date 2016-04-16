<div id="container">
	<div id="main"> 
		<div class="wrapper">
			<div class="text_wrapper">
					<?php echo form_open('ownprofile', array('id' => 'form'));?>
					<table>
						<tr>
							<td><label class="forlabel">Username:</label></td>
							<td colspan="2"><input id="nicknameprofile" type="text" name="username"></td>
							<td><div class="error"><?php echo form_error('username'); ?></div></td>
						</tr>
						<tr>
							<td><label class="forlabel">First name:</label></td>
							<td colspan="2"><input id="firstnameprofile" type="text" name="firstname"></td>
							<td><div class="error"><?php echo form_error('firstname'); ?></div></td>
						</tr>
						<tr>
							<td><label class="forlabel">Last name:</label></td>
							<td colspan="2"><input id="lastnameprofile" type="text" name="lastname"></td>
							<td><label class="error"><?php echo form_error('lastname'); ?></label></td>
						</tr>
						<tr>
							<td><label class="forlabel">Email:</label></td>
							<td colspan="2"><input id="emailprofile" type="email" name="email"></td>
							<td><label class="error"><?php echo form_error('email'); ?></label></td>
						</tr>                        
						<tr>
							<td><label class="forlabel">Password:</label></td>
							<td colspan="2"><input type="password" name="password" placeholder="give a new password" ></td>
							<td><label class="error"><?php echo form_error('password'); ?></label></td>
						</tr>                        
						<tr>
							<td><label class="forlabel">Retype password:</label></td>
							<td colspan="2"><input type="password" name="passwordconfirmation"></td>
							<td><label class="error"><?php echo form_error('passwordconfirmation'); ?></label></td>
						</tr>
						<tr>
							<td><label class="forlabel">Birthdate:</label></td>
							<td colspan="2"><input id="dateprofile" type="date" name="date"></td>
							<td><label class="error"><?php echo form_error('date'); ?></label></td>
						</tr>
						<tr>
							<td>I am:</td>
							<td>                                    
								<input id="male" type="radio" name="gender" value="m" <?php echo set_radio('gender', 'm');?>>
								<label for="male">Male </label>
							   
							</td>
							<td>
								<input id="female" type="radio" name="gender" value="v" <?php echo set_radio('gender', 'v');?> >
								<label for="female">Female </label>
							</td>
						</tr> 
						<tr>
							<td>I like:</td>
							<td>                                    
								<input id="male" type="checkbox" name="attraction" value="male" <?php echo set_checkbox('attraction', 'male');?>>
								<label for="male">Males </label>
							   
							</td>
							<td>
								<input id="female" type="checkbox" name="attraction" value="female" <?php echo set_checkbox('attraction', 'female');?>>
								<label for="female">Females </label>
							</td>
							<td><label class="error"><?php echo form_error('attraction'); ?></label></td>
						</tr>                             
						<tr>
						<tr>
							<td><label class="forlabel">Minimum age preference:</label></td>
							<td colspan="2"><input id="minap" type="number" name="minAge"></td>
							<td><label class="error"><?php echo form_error('minAge'); ?></label></td>
						</tr>
						<tr>
							<td><label class="forlabel">Maximum age preference:</label></td>
							<td colspan="2"><input id="maxap" type="number" name="maxAge"></td>
							<td><label class="error"><?php echo form_error('maxAge'); ?></label></td>
						</tr>
						<tr>
							<td><label class="forlabel">Description:</label></td>
							<td colspan="2" rowspan="4">
								<textarea id="descriptionuser" cols="40" rows="4" type="text" name="description" placeholder="Write a description about yourself, this should have at least 100 characters"><?php echo set_value('description'); ?></textarea></td>
							<td><label class="error"><?php echo form_error('description'); ?></label></td>
						</tr>

						</tr>
					</table>
				<div id="brandsTest">
					<?php
					echo $brands;
					?>
				</div>

				<input type="submit" name="submit">
				</form>                                       
			</div>                
		</div>
	</div>        
</div>
<script>
	$(document).ready(function () {
		<?php if(isset($_SESSION['loggedIn'])){?>
		//this is if we are on our own page
			<?php if($_SESSION['userID'] == $userdata['userID']){?>
				$.get("./profilepersonality", {'ID': <?php echo $userdata['userPersonality']?>}, function (personalitytype){
					$.get("./profilepersonality", {'ID': <?php echo $userdata['userPersonalityPref']?>}, function (personalitypref){				
						<?php if(isset($_SESSION['loggedIn'])){?>
								$("#profilepic").attr("src", "./images/profilepic/<?php echo $userdata["userID"]?>.jpg")					
						<?php }else{?>
								$("#profilepic").attr("src", "./images/profilepic/<?php echo $userdata["userSex"]?>silhoutte.jpg")					
						<?php } ?>
						
						//set the input as it is in our database
						$("#nicknameprofile").attr('value', '<?php echo $userdata['userNickname']?>');
						$("#firstnameprofile").attr('value', '<?php echo $userdata['userFirstName']?>');
						$("#lastnameprofile").attr('value', '<?php echo $userdata['userLastName']?>');
						$("#descriptionuser").html('<?php echo $userdata['userDescription']?>');
						$("#emailprofile").attr('value','<?php echo $userdata['userEmail']?>');
						$("#minap").attr('value','<?php echo set_value('minAge', $userdata['userMinAgePref'])?>');
						$("#maxap").attr('value','<?php echo set_value('maxAge', $userdata['userMaxAgePref'])?>');
						$("#dateprofile").attr('value','<?php echo set_value('date', $userdata['userBirthdate'])?>');
						
						var $radios = $('input:radio[name=gender]');
						if("<?php echo $userdata['userSex']?>" === "m") {
							$radios.filter('[value=m]').prop('checked', true);
						}else{
							$radios.filter('[value=v]').prop('checked', true);
						}
						
						var $radios2 = $('input:checkbox[name=attraction]');
						if("<?php echo $userdata['userSexPref']?>" === "m") {
							$radios2.filter('[value=male]').prop('checked', true);
						}else if("<?php echo $userdata['userSexPref']?>" === "f"){
							$radios2.filter('[value=female]').prop('checked', true);
						}else{
							$radios2.filter('[value=male]').prop('checked', true);
							$radios2.filter('[value=female]').prop('checked', true);
						}

					});
				});
			<?php } ?>
		<?php } ?>			
	});	

	
	
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
