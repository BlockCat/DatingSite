
    <div >
        <div class="text_wrapper">
            <div id="profileviewer">
                <?php for ($i = 0; $i < 0; $i++) {?>
                <div class="profile">
                    <div class="profilethumbnail">
                        <a id="link<?php echo $i?>"><img id="profilepic<?php echo $i?>" alt="profilepicture" height="150" width="150"></a>
                    </div>
                    <div class="profileinfo">
                        <a id="nicknameprofile<?php echo $i?>"></a>
                        <p id="sexprofile<?php echo $i?>"></p>
                        <p id="ageprofile<?php echo $i?>"></p>
                        <p id="personalityprofile<?php echo $i?>"></p>
                        <p id="brandsprofile<?php echo $i?>"></p>
                        <p id="descriptionprofile<?php echo $i?>"></p>
                        <p id="distance<?php echo $i?>"></p>
                    </div>

                </div>
                <?php }?>
            </div>
            <button id="more">More </button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            loadpage(0);			
        });		
				
				
        $("#more").click(function nextpage() {
            <?php if ($this->session->userdata('loggedIn')) {?>
                $("#form #page").val(page++);
                loadpage(page);
            <?php } else {?>
                alert('Please sign up to view more of our members!');

            <?php }?>
        });

        var page = 1;
        //For future scrolling down while searching dynamically loading etc...
        function loadpage(page) {
            var formarray = $("#form").serialize();

            $.get("<?php echo base_url('search/get_profiles') ?>", formarray, function(data) {
                console.log('response');
                for (var i = 0; i < 12 && i < data.length; i++) {
                    create_profile(data[i], i, page);
                }
				set_feedback(data, page - 1);					
				console.log("herherherherherh");
                if (data.length == 0) {
                    alert('There are no more matches');
                    $("#more").hide();
                }
            });
        }

		function set_feedback(data, page){
			if(page < 0){
				page=0;
			}
			//---------- moet veranderd worden voor 6 personen....
			end = (page * 12)+12;
			for (let i= page * 12; i < end; i++) {
					$.get("./likecheck", {'userID':<?php echo $_SESSION['userID']?>,
					'profileID':data[i - (page * 12)].userID}, function (likeRelation){
						console.log("#profilepic" + String(i));
						$("#profilepic" + String(i)).css('border-style', 'solid');
						$("#profilepic" + String(i)).css('border-width', '0.3em');

						if(likeRelation == "n"){
							$("#profilepic" + String(i)).css('border-color', '#990000');				
						}
						else if(likeRelation == "r"){
							$("#profilepic" + String(i)).css('border-color', '#009933');					
						}
						else if(likeRelation == "g"){
							$("#profilepic" + String(i)).css('border-color', '#0033cc');					
						}
					});	
					//-------------	
				
			}					
		}
		
        function create_profile(data, i, page) {


            var profile = $("<div/>", {
               class: 'profile'
            });
			
			if(page - 1 < 0){
				normal = 0
			}
			else{
				normal = page -1;
			}

            var img = $("<div class=\"profilethumbnail\"><a><img src=\""+ data.image +"\"  id=\"profilepic" + (i+ normal *12 ) + "\" alt=\"profilepicture\" height=\"150\" width=\"150\"></a></div>");
            profile.append(img);
			

            var info = $("<div/>", {
                class: "profileinfo"
            });

            info.append($("<p><b>" + data.userNickname + "</b></p>"));
            info.append($("<p>Sex: " + data.userSex + "</p>"));
            info.append($("<p>Age: " + data.userBirthdate + "</p>"));
            info.append($("<p>" + data.personality + "</p><hr>"));
            info.append($("<p>" + data.userDescription.slice(0, 50) + "</p><hr>"));
            var brands = $("<p></p>");

            if (data.brands.length > 0) {
                brands.html(data.brands[0]);
                for (var i = 1; i < data.brands.length && i < 5; i++) {
                    brands.html(brands.html() + ', ' + data.brands[i]);
                }
            } else {
                brands.html('No brands');
            }
            info.append(brands);
            info.append($("<p>" + data.distance + "</p>"));

            console.log(data);

            profile.append(info);

            var linked = $("<a target='_blank' href=./profilepage?ID=" + data.userID +"></a>");
            linked.append(profile);
            $("#profileviewer").append(linked);
			
			
			
			
        }

    </script>
