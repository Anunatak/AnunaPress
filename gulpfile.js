var elixir = require('laravel-elixir');

elixir(function(mix) {
  mix.sass('./assets/scss/login/login.scss', './assets/css/login.css');
  mix.sass('./assets/scss/adminbar/adminbar.scss', './assets/css/adminbar.css');
  mix.sass('./assets/scss/dashboard/dashboard.scss', './assets/css/dashboard.css');
})
