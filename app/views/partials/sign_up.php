<div id="signup_div">
    <form id="registration_form" name="registration_form" method="POST" action="index.php?page=register"  onsubmit="return signUp();">
        <h4>Become our member now!</h4>
        <table class="table_registration" id="table_signup" >
            <tr>
                <th colspan="2">Sign up</th>
            </tr>
            <tr>
                <td><input type="text" name="first_name" id="first_name" placeholder="First name"/></td>
                <td><input type="text" name="last_name" id="last_name" placeholder="Last name"/></td>
            </tr>
            <tr>
                <td><input type="text" name="username_signup" id="username_signup" placeholder="Username"/></td>
                <td><input type="password" name="password_signup" id="password_signup" placeholder="Password"/></td>
            </tr>

            <tr>
                <td><input type="password" name="repeat_password" id="repeat_password" placeholder="Repeat password"/></td>
                <td><input type="email" name="user_email" id="user_email" placeholder="Email"/></td>
            </tr>

            <tr>
                <td colspan="2"><input type="submit" id="btnSignup" name="btnSignup" value="Sign up"/><td>
            </tr>
        </table>
    </form>
</div>
