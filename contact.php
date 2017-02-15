<?php include_once('header.php'); ?>




<article id="contact-page-form-section">
  <div class="container-fluid has-breakpoint">

    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">

        <div id="contact-page-form-title">
          <h2>love to hear from you!</h2>
          <p>Please fill up the contact form and we will get back to you within 1 to 2 working days. If you don’t hear from us, or if it is an urgent matter, please do not hesitate to call us instead.</p>
        </div> <!-- contact-page-form-title -->

      </div>
    </div>



    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">

        <div id="contact-page-form-container">
          <div id="contact-page-form" class="simple-form-check add-element-version">
            <form>

              <div class="row">
                <div class="col-md-6">

                  <div class="contact-page-column-01">
                    <label for="nameofitem">salutation<span>*</span></label>

                    <div class="dropdown">
                      <select id="nameofitem" name="nameofitem">
                        <option>Option 01</option>
                        <option>Option 02</option>
                        <option>Option 03</option>
                      </select>
                    </div>

                    <label for="nameofitem">email address<span>*</span></label>
                    <input type="text" id="nameofitem" name="nameofitem">

                    <label>preference of contact</label>

                    <div class="row">
                      <div class="col-md-6">
                        <div>
                          <input type="checkbox" name="test">
                          <label for="test" class="checkbox-label"><span></span><p>Email</p></label>
                        </div>

                      </div>
                      <div class="col-md-6">

                        <div>
                          <input type="checkbox" name="test">
                          <label for="test" class="checkbox-label"><span></span><p>Email</p></label>
                        </div>
                        
                      </div>
                    </div>
                  </div> <!-- contact-page-column-01 -->

                </div>
                <div class="col-md-6">

                  <div class="contact-page-column-02">
                    <label for="nameofitem">full name*</label>
                    <input type="text" id="nameofitem" name="nameofitem">

                    <label for="nameofitem">contact number</label>
                    <input type="text" id="nameofitem" name="nameofitem">

                    <label for="nameofitem">order id (if applicable)</label>
                    <input type="text" id="nameofitem" name="nameofitem">

                    <label>Image</label>
                    <div id="imgur-upload-container">
                      <div class="dropzone"></div>
                    </div>
                    
                  </div> <!-- contact-page-column-02 -->

                </div>
              </div> <!-- row -->

              <label>subject</label>
              <input type="text" id="nameofitem" name="nameofitem" class="required" placeholder="this is a placeholder">

              <label>message</label>
              <textarea></textarea>

              <div class="cta-container">
                <button type="submit" class="square-cta">send message</button>
              </div>


            </form>          
          </div>
        </div> <!-- #contact-page-form-container -->

      </div>
    </div>
  </div>
</article>


<article id="contact-page-detail-section">
  <div class="container-fluid has-breakpoint">
    <div class="row">
      <div class="col-md-6">

        <div id="contact-page-detail-map-container">

          <div id="contact-page-detail-map" 
            data-home-icon="shopify-theme/assets/contact-pin.svg"
            data-lat="1.333848" 
            data-lng="103.697271">
            
          </div>

        </div>
        

      </div> <!-- col-md-6 -->
      <div class="col-md-1"></div>
      <div class="col-md-5">

        <div id="contact-page-detail-copy">
          <div id="contact-page-detail-copy-title">
            <h1>Get in Touch</h1>
          </div>

          <div id="contact-page-detail-copy-item-container">

            <div class="contact-page-detail-copy-item">
              <h4>general or order enquiries</h4>
              <p><span>E</span><a href="mailto:hello@kindredteas.com">hello@kindredteas.com</a></p>
            </div>
            <div class="contact-page-detail-copy-item">
              <h4>collaborations and other business opportunities</h4>
              <p><span>E</span><a href="mailto:marketing@kindredteas.com">marketing@kindredteas.com</a></p>
            </div>
            <div class="contact-page-detail-copy-item">
              <h4>contact no.</h4>
              <div class="row">
                <div class="col-md-5">
                  <p><span>T</span>+65 6570 6571</p>
                </div>
                <div class="col-md-5">
                  <p><span>M</span>+65 9088 4902</p>
                </div>
              </div>
            </div>
            <div class="contact-page-detail-copy-item">
              <h4>warehouse address</h4>
              <p>3 Soon Lee Street, #03-08 Pioneer Junction, Singapore 627606</p>
            </div>
            <div class="contact-page-detail-copy-item">
              <h4>office address</h4>
              <p>3 Soon Lee Street #03-02 Pioneer Junction Singapore 627606</p>
            </div>
          </div> <!-- contact-page-detail-copy-item-container -->

          <div id="contact-page-detail-copy-fineprint">
            <small>Company Registration No. 201100451Z</small>
          </div>

        </div> <!-- contact-page-detail-copy -->


      </div> <!-- col-md-5 -->
    </div> <!-- row -->
  </div>
</article>


<!-- important -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2SOmCXdM5TEYYk81BFxiFwJZ_Z56moYo&v=3.exp"></script>


<?php include_once('footer.php'); ?>