<?php
$this->script = '/assets/js/login.js';
?>

<div id="login-form" class="login-form">
  <form action="/login-check" method="post" v-on:submit.prevent="submitForm">
    <h2 class="text-center">Log in</h2>
    <div class="form-group">
      <input
        v-model="username"
        :class="{'is-invalid': errors.username}"
        type="text"
        class="form-control"
        placeholder="Username"
        required="required"
      >
    </div>
    <div class="form-group">
      <input
        v-model="password"
        :class="{'is-invalid': errors.password}"
        type="password"
        class="form-control"
        placeholder="Password"
        required="required"
      >
    </div>
    <div class="form-group">
      <small v-if="errors" v-for="error in errors" class="text-danger">{{ error }}</small>
    </div>
    <div class="form-group">
      <button id="login-btn" type="submit" class="btn btn-primary btn-block" :class="{ disabled: loading }">Log in</button>
      <a class="btn btn-secondary btn-block" href="/">Go To Home</a>
    </div>
  </form>
</div>
