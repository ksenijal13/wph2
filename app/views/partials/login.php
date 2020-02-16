<div id="login_div">
    <form id="login_form" name="login_form" method="POST" action="index.php?page=login"  onsubmit="return login();">
        <h4>Already have an account?</h4>
        <table class="table_registration">
            <tr>
                <th>Log in</th>
            </tr>
            <tr>
                <td><input type="text" name="username_login" id="username_login" placeholder="Username"/></td>
            </tr>
            <tr>
                <td><input type="password" name="password_login" id="password_login" placeholder="Password"/></td>
            </tr>
            <tr>
                <td><input type="submit" id="btnLogin" name="btnLogin" value="Log in"</td>
            </tr>
        </table>
    </form>
</div>
