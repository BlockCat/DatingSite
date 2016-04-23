
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
            $("#form #page").val(page++);
            loadpage(page);
        });

        var page = 1;
        //For future scrolling down while searching dynamically loading etc...
        function loadpage(page) {
            var formarray = $("#form").serialize();

            $.get("<?php echo base_url('search/get_profiles') ?>", formarray, function(data) {
                console.log('response');
                for (var i = 0; i < 12 && i < data.length; i++) {
                    create_profile(data[i]);
                }
                if (data.length == 0) {
                    alert('There are no more matches');
                    $("#more").hide();
                }
            });
        }

        function create_profile(data) {


            var profile = $("<div/>", {
               class: 'profile'
            });


            var img = $("<div class=\"profilethumbnail\"><a><img src=\""+ data.image +"\" alt=\"profilepicture\" height=\"150\" width=\"150\"></a></div>");
            profile.append(img);

            var info = $("<div/>", {
                class: "profileinfo"
            });

            info.append($("<p>" + data.userNickname + "</p>"));
            info.append($("<p>" + data.userSex + "</p>"));
            info.append($("<p>" + data.userBirthdate + "</p>"));
            info.append($("<p>" + data.personality + "</p>"));
            info.append($("<p>" + data.userDescription.slice(0, 50) + "</p>"));
            info.append($("<p>" + data.personality + "</p>"));
            info.append($("<p>" + data.distance + "</p>"));

            profile.append(info);

            var linked = $("<a target='_blank' href=./profilepage?ID=" + data.userID +"></a>");
            linked.append(profile);
            $("#profileviewer").append(linked);
        }

    </script>
