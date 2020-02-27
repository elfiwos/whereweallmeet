<div id="content" class="clearfix">
	<div class="top_con">
		<div class="image_con">
			<?php echo Asset::img('profile/dating_agent.jpg'); ?>
			<p>Rachel Vanhook</p>
		</div>
		<div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
		<div class="blank-img"><?php echo Asset::img('profile/blank.jpg'); ?></div>
		 <div class="border-icon1"></div>
	</div>

	<div class="main-con">
		<div class="inner-main-con">
            <div class="header-section">
                <p class="header-text pull-left">Hello! & Welcome to WhereWeAllMeet.com </p>
                <div class="clearfix"></div>
            </div>

             <?php echo Form::open(array("action" => "profile/update_profile","enctype" => "multipart/form-data", "id" => "profile-form", "class" => "quick-signup")) ?>
            
            	<div class="content">
            		
            		<p class="lbl"><strong>Where are you located?</strong></p>
            		<div class="form-inline">
	            		<input name="city" type="text" placeholder="City..." >

	            		<select name="state">
	            			<option value="0">State...</option>
	            			<?php foreach ($state as $item) : ?>
	            				<option value="<?php echo $item->name; ?>"><?php echo $item->name; ?></option>
                    		<?php endforeach; ?>
	            		</select>
	            		<input name="zip" type="text" placeholder="Zip/Postal">
            		</div>
            		
            		<p class="lbl">When is your birthday?</p>

            		<div class="form-inline">
	            		<select name="month">
	            			<option value="0">Month...</option>
	            			<?php for ($i = 1; $i <= 12; $i++): ?>                      		
                        		<option><?php echo $i; ?></option>
                   			 <?php endfor; ?>
	            		</select>
	            		<select name="day">
	            			<option value="0">Day...</option>
	            			<?php for ($i = 1; $i <= 31; $i++): ?>
                        		<option ><?php echo $i; ?></option>
                    		<?php endfor; ?>
	            		</select>
	            		<select name="year">
	            			<option value="0">Year...</option>
	            			<?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>                      
                       		 	<option><?php echo $i; ?></option>
                   			 <?php endfor; ?>
	            		</select>	            			            		            		
            		</div>

            		<p class="lbl">Tell me about your hobbies? Be impressive!</p>
            		<div class="form-inline">
            			<textarea name="about_me"></textarea>
            			<p class="below-bio">The more you write, the easier it is for others to get to know you're interests. Minimum 80 Characters</p>
            		</div>
            		
            		<p class="lbl">Upload a profile pic (optional)</p>
            		
            		<div class="form-inline">
						<p class="pull-right pic-suggestion">(We strongly suggest that you upload a picture that 
							captures your personality. People are visual, they like 
							to see others.)</p>            		
	            		<input class="pull-left pro-pic-upload" type="file" name="profile_pic">
	            		
						<div class="clearfix"></div>
					</div>
            	 </div>
            	 	
            	<button class="yellow-submit" type="submit"><span>I'M FINISHED</span></button>
         </div>
		<?php echo Form::close(); ?>
         <div class="border-icon2"></div>
         <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>

</div>