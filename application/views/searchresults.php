
    <div>

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

            $.post("<?php echo site_url('search/get_profiles') ?>", formarray, function(data) {
                console.log('response');
                console.log(data);
                if (data.length > 0) {

                    var first = create_profile(data[0], 0, page);
                    $("html, body").animate({
                        scrollTop: first.offset().top
                    }, 500);
                }
                for (var i = 1; i < 12 && i < data.length; i++) {
                    create_profile(data[i], i, page);
                }
                if (data.length == 0) {
                    alert('There are no more matches');
                    $("#more").hide();
                    return;
                }
            });
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
            var imgs = $("<img src=\""+ data.image +"\"  id=\"profilepic" + (i+ normal *12 ) + "\" alt=\"profilepicture\" height=\"150\" width=\"150\">");
            var img = $("<div class=\"profilethumbnail\"></div>");
            <?php if($this->session->userdata('loggedIn')) {?>

                if (data.likerelation == 'n') {
                    imgs.css('border-color', '#990000');
                    imgs.css('border-width', '0.3em');
                    imgs.css('border-style', 'solid');
                } else if (data.likerelation == 'r') {
                    imgs.css('border-color', '#009933');
                    imgs.css('border-width', '0.3em');
                    imgs.css('border-style', 'solid');
                } else if (data.likerelation == 'g') {
                    imgs.css('border-color', '#0033cc');
                    imgs.css('border-width', '0.3em');
                    imgs.css('border-style', 'solid');
                }
            <?php } ?>
            img.append(imgs);
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



            profile.append(info);

            var linked = $("<a target='_blank' href='<?php echo site_url()?>/profilepage?ID=" + data.userID +"'></a>");
            linked.append(profile);
            $("#profileviewer").append(linked);
            return linked;
        }

    </script>
