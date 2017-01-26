<?php include_once('header.php'); ?>


<div class="grid">

  <div class="grid__item large--one-third push--large--one-third text-center">

    
    <div class="note form-success" id="ResetSuccess" style="display:none;">
      We've sent you an email with a link to update your password.
    </div>

    <div id="CustomerLoginForm" class="form-vertical">
      <form method="post" action="https://kindredteas.com/account/login" id="customer_login" accept-charset="UTF-8"><input type="hidden" value="customer_login" name="form_type"><input type="hidden" name="utf8" value="✓">

        <h1>Login</h1>

        

        <label for="CustomerEmail" class="hidden-label">Email</label>
        <input type="email" name="customer[email]" id="CustomerEmail" class="input-full" placeholder="Email" autocorrect="off" autocapitalize="off" autofocus="">

        
          <label for="CustomerPassword" class="hidden-label">Password</label>
          <input type="password" value="" name="customer[password]" id="CustomerPassword" class="input-full" placeholder="Password">
        

        <p>
          <input type="submit" class="btn btn--full" value="Sign In">
        </p>
        <p><a href="/">Return to Store</a></p>
        <p><a href="/account/register" id="customer_register_link">Create account</a></p>
        
          <p><a href="#recover" id="RecoverPassword">Forgot your password?</a></p>
        

      </form>
    </div>

    
    <div id="RecoverPasswordForm" style="display: none;">

      <h2>Reset your password</h2>
      <p>We will send you an email to reset your password.</p>

      <div class="form-vertical">
        <form method="post" action="https://kindredteas.com/account/recover" accept-charset="UTF-8"><input type="hidden" value="recover_customer_password" name="form_type"><input type="hidden" name="utf8" value="✓">

          

          
          

          <label for="RecoverEmail" class="hidden-label">Email</label>
          <input type="email" value="" name="email" id="RecoverEmail" class="input-full" placeholder="Email" autocorrect="off" autocapitalize="off">

          <p>
            <input type="submit" class="btn btn--full" value="Submit">
          </p>
          <button type="button" id="HideRecoverPasswordLink" class="text-link">Cancel</button>
        </form>
      </div>

    </div>

    
    

  </div>

</div>

<?php include_once('footer.php'); ?>