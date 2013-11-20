    <div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">
            <?php echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Updating <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> Competition updated with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
      echo validation_errors();

      echo form_open('admin/competitions/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
        	
          <div class="control-group">
            <label for="inputError" class="control-label">Description</label>
            <div class="controls">
              <input type="text" id="" name="compt_name" value="<?php echo $product[0]['compt_name']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Logo</label>
            <div class="controls">
              <input type="text" id="" name="logo" value="<?php echo $product[0]['logo']; ?>">
              <!--<span class="help-inline">Cost Price</span>-->
            </div>
          </div>
                    
          <div class="control-group">
            <label for="inputError" class="control-label">Privacy Text</label>
            <div class="controls">
              <input type="text" id="" name="privacy_text" value="<?php echo $product[0]['privacy_text'];?>">
              <!--<span class="help-inline">Cost Price</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">About Us</label>
            <div class="controls">
              <input type="text" name="about_us" value="<?php echo $product[0]['about_us']; ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Prize Details</label>
            <div class="controls">
              <input type="text" name="prize_details" value="<?php echo $product[0]['prize_details']; ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>

          <div class="control-group">
            <label for="inputError" class="control-label">Contest Rules</label>
            <div class="controls">
              <input type="text" name="contest_rules" value="<?php echo $product[0]['contest_rules']; ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Website Conditions</label>
            <div class="controls">
              <input type="text" name="website_conditions" value="<?php echo $product[0]['website_conditions']; ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
          
          <div class="control-group">
            <label for="inputError" class="control-label">Page Link</label>
            <div class="controls">
              <input type="text" name="page_link" value="<?php echo $product[0]['page_link']; ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>

          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <button class="btn" type="reset">Cancel</button>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>