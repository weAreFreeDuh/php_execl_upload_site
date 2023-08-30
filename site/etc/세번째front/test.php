<!DOCTYPE html>
<html>
<head>
</head>
<style>
/* Your CSS styles here */
@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100);
/* Global Styles */
body {
  font-family: "Roboto", helvetica, arial, sans-serif;
  background-color: #3e94ec;
  font-size: 16px;
  font-weight: 400;
  text-rendering: optimizeLegibility;
}

/* Login Form Styles */
.login-form {
  background: white;
  border-radius: 3px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  max-width: 400px;
  margin: auto;
  padding: 20px;
}

.login-form input,
.login-form select {
  display: block;
  margin-bottom: 15px;
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  font-size: 16px;
}

.login-form select {
  /* Additional select styles here */
}

.login-form button {
  background: #007BFF;
  border: none;
  border-radius: 3px;
  color: white;
  cursor: pointer;
  display: block;
  font-size: 16px;
  padding: 10px;
  width: 100%;
}

.login-form button:hover {
  background: #0056b3;
}

/* Additional Input Styles */
.input {
  /* Additional input styles here */
}

/* Additional Select Styles */
.select {
  /* Additional select styles here */
}
</style>
<body>
  <div class="login-form">
    <form>
      <input type="text" class="input" placeholder="Username">
      <input type="password" class="input" placeholder="Password">
      <select class="select">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
      </select>
      <button class="button">Login</button>
    </form>
  </div>
</body>
</html>