
    <div >
        <div class="text_wrapper">
            <div id="profileviewer">
                <?php for ($i = 0; $i < 12; $i++) {?>
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
                    </div>

                </div>
                <?php }?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $.get("<?php echo base_url('search/get_profiles') ?>", $("#form").serialize(), function(data) {
                console.log(data);
                for (var i = 0; i < 12 && i < data.length; i++) {
                    $("#profilepic" + i).attr('src', data[i].image);
                    $("#nicknameprofile" + i).html(data[i].userNickname);
                    $("#sexprofile" + i).html(data[i].userSex);
                    $("#ageprofile" + i).html(data[i].userBirthdate);
                    $("#personalityprofile" + i).html(data[i].personality);
                    $("#descriptionprofile" + i).html(data[i].userDescription.slice(0, 50));
                }
            });
        });

        function create_profile(data) {

        }

    </script>
