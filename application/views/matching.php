<div class="wrapper" id="matching">
    <div class="flashy_wrapper">
        <form style="display: none" id="form" method='post' action="<?php site_url('search');?>">
                Who liked me: <input type="checkbox" value="1" name="wholikedme" <?php echo set_checkbox('wholikedme', '1', $wholikedme)?>>
                Who did I like: <input type="checkbox" value="1" name="whoiliked" <?php echo set_checkbox('whoiliked', '1', $whoiliked)?>>
            <input type="hidden" value="0" name="page" id="page">

        </form>
        <div id="mylinks">
            <a href="<?php echo site_url('matching?mode=0')?>"><button>Find a match</button></a>
            <a href="<?php echo site_url('matching?mode=1')?>"><button>My likes</button></a>
            <a href="<?php echo site_url('matching?mode=2')?>"><button>Who likes me</button></a>
            <a href="<?php echo site_url('matching?mode=3')?>"><button>Mutual likes</button></a>
        </div>

    </div>
</div>