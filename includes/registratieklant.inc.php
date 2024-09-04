<div class="container">
    <?php
    if(isset($_GET['error'])){
        echo "This email is already registered. Please use another mail." ;
    }?>
    <form action="php/register.php" method="POST" class="form">
        <h2>Register</h2>
        <div class="input-group">
            <label for="name">Naam</label>
            <input type="text" name="name" maxlength="50" required>
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" maxlength="50" required>
        </div>
        <div class="input-group">
            <label for="password">Wachtwoord</label>
            <input type="password" name="password" maxlength="50" required>
        </div>
        <div class="input-group">
            <label for="confirmpassword">Herhaal Wachtwoord</label>
            <input type="password" name="confirmpassword" maxlength="50" required>
        </div>
        <div class="input-group" id="address-group" style="display: none;">
            <label for="street">Adres</label>
            <input type="text" name="address" maxlength="50">
        </div>
        <div class="input-group" id="zipcode-group" style="display: none;">
            <label for="zipcode">Postcode</label>
            <input type="text" name="zipcode" maxlength="50">
            <span id="postcodeError" class="error"></span>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="register">Register</button>
        </div>
        <h4>
            Already have an account? Sign in <a href="index.php?page=loginklant">here!</a>
        </h4>
    </form>
</div>