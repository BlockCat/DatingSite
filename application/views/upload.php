    <div id="container">
        <div id="main">
            <div class="wrapper">
                <div class="text_wrapper">
                    <img id="profileimage" alt="Profile picture" src="<?php echo $imgsrc ?>""/>
                    <?php echo form_error('userfile')?>
                    <?php echo form_open('profilepage/upload', array('enctype' => 'multipart/form-data')) ?>
                        <input type="file" id="profileinput" name="userfile" >
                        <input type="submit" name="submit">
                    </form>
                    <button><a>Back to my profile</a></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('change', '#profileinput', function() {
            var reader = new FileReader();
            reader.readAsDataURL(document.getElementById("profileinput").files[0]);
            reader.onload = function (event) {
                document.getElementById('profileimage').src = event.target.result;
            }
        });

    </script>
</body>
</html>