<div id="container">
	<div id="main"> 
		<div class="wrapper">
			<div class="text_wrapper">
				<?php echo form_open('admin', array('id' => 'form'));?>
					<table>
						<tr>
							<td><label class="forlabel">Alpha:</label></td>
							<td colspan="2"><input id="alpha" type="text" name="alpha" value="<?php echo $datevars["alpha"];?>"></td>
							<td><div class="error"><?php echo form_error('alpha'); ?></div></td>
						</tr>
						<tr>
							<td><label class="forlabel">X-factor:</label></td>
							<td colspan="2"><input id="xfactor" type="text" name="xfactor" value="<?php echo $datevars["x"];?>"></td>
							<td><div class="error"><?php echo form_error('xfactor'); ?></div></td>
						</tr>
						<tr></tr>						
						<tr>
							<td>Distance:</td>
							<td class="admin">
								<input id="overlap" type="radio" name="distance" value="o" <?php echo set_radio('distance', 'o');?> >
								<label>Overlap</label>
							</td>							
							<td class="admin">
								<input id="jacard" type="radio" name="distance" value="j" <?php echo set_radio('distance', 'j');?> >
								<label>Jaccard</label>
							</td>
							<td class="admin">
								<input id="cosine" type="radio" name="distance" value="c" <?php echo set_radio('distance', 'c');?> >
								<label>Cosine</label>
							</td>
							<td class="admin">                                    
								<input id="dice" type="radio" name="distance" value="d" <?php echo set_radio('distance', 'd');?>>
								<label>Dice</label>							   
							</td>							
						</tr> 
					</table>
					<input type="submit" name="submit">
				</form>                                       
			</div>                
		</div>
	</div>        
</div>
<script>
	$(document).ready(function () {
		var olddistance = '<?php echo $datevars['d'];?>';
		var $radios = $('input:radio[name=distance]');
		if(olddistance === "o") {
			$radios.filter('[value=o]').prop('checked', true);
		}else if (olddistance === "j"){
			$radios.filter('[value=j]').prop('checked', true);
		}else if (olddistance === "c"){
			$radios.filter('[value=c]').prop('checked', true);
		}else if(olddistance === "d"){
			$radios.filter('[value=d]').prop('checked', true);
		}
	});
</script>
