<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/test.css">
  <title>Document</title>
</head>

<body>
  <div class="login-wrap">
    <div class="login-html">
      <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign
        In</label>

      <div class="login-form">
        <!-- <div class="sign-in-htm"> -->
        <div class="group">
          <label for="user" class="label">Username</label>
          <input id="user" type="text" class="input">
        </div>

        <div class="group">
          <label for="pass" class="label">Password</label>
          <input id="pass" type="password" class="input" data-type="password">
        </div>
        <div class="group">
          <!-- <input id="check" type="checkbox" class="check" checked>
                        <label for="check"><span class="icon"></span> Keep me Signed in</label> -->
        </div>
        <div class="group">
          <input type="submit" class="button" value="Sign In">
        </div>
        <div class="hr"></div>
        <div class="foot-lnk">
          <!-- <a href="#forgot">Forgot Password?</a> -->
        </div>
        <!-- </div> -->
        <div class="group">
          <select>
            <option>test</option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="table-title">
    <h3>Data Table</h3>
  </div>
  <table class="table-fill">
    <thead>
      <tr>
        <th class="text-left">Month</th>
        <th class="text-left">Sales</th>
      </tr>
    </thead>
    <tbody class="table-hover">
      <tr>
        <td class="text-left">January</td>
        <td class="text-left">$ 50,000.00</td>
      </tr>
      <tr>
        <td class="text-left">February</td>
        <td class="text-left">$ 10,000.00</td>
      </tr>
      <tr>
        <td class="text-left">March</td>
        <td class="text-left">$ 85,000.00</td>
      </tr>
      <tr>
        <td class="text-left">April</td>
        <td class="text-left">$ 56,000.00</td>
      </tr>
      <tr>
        <td class="text-left">May</td>
        <td class="text-left">$ 98,000.00</td>
      </tr>
    </tbody>
  </table>
</body>

</html>