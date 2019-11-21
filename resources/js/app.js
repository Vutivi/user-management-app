/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('modal', {
  template: '#modal-template'
})

var app = new Vue({
  el: '#vue-wrapper',

  data: {
    users: [],
    hasError: true,
    successAction: true,
    showCreateModal: false,
    showEditModal: false,
    successMessage: '',
    e_first_name: '',
    e_surname: '',
    e_email: '',
    e_username: '',
    e_password: '',
    e_id: '',
    newUser: { 'first_name': '','surname': '','email': '', 'username': '', 'password': '' },
   },
  mounted: function mounted() {
    this.getVueUsers();
  },
  methods: {
    getVueUsers: function getVueUsers() {
      var _this = this;

      axios.get('/vueusers').then(function (response) {
        _this.users = response.data;
      });
    },
    setVal(val_id, val_first_name, val_surname, val_email, val_username, val_password) {
        this.e_id = val_id;
        this.e_first_name = val_first_name;
        this.e_surname = val_surname;
        this.e_email = val_email;
        this.e_username = val_username;
        this.e_password = val_password;
    },

    createUser: function createUser() {
      var _this = this;
      var input = this.newUser;
      this.hasError = true;

      if (input['first_name'] == '' || input['surname'] == '' || input['email'] == '' || input['username'] == '' || input['password'] == '') {
        this.hasError = false;
      } else {
        axios.post('/vueusers', input).then(function (response) {
            _this.newUser = { 'first_name': '', 'surname': '',  'email': '', 'username': '', 'password': '' };
            _this.getVueUsers();
            _this.showCreateModal=false;
            _this.successMessage = 'Succesfully created user!';
            _this.successAction = false;
        });
      }
    },

    editUser: function(){
        var id = document.getElementById('e_id');
        var firstName = document.getElementById('e_first_name');
        var lastName = document.getElementById('e_surname');
        var email = document.getElementById('e_email');
        var username = document.getElementById('e_username');
        var password = document.getElementById('e_password');

        var _this = this;
        _this.hasError = true;

        axios.post('/editusers/' + id.value, {'first_name': firstName.value, 'surname': lastName.value, 'email': email.value, 'username': username.value, 'password': password.value })
        .then(response => {
            _this.getVueUsers();
            _this.showEditModal=false;
            _this.successMessage = 'Succesfully edited user!'
            _this.successAction = false; 
        });       
  },
    deleteUser: function deleteUser(user) {
        var _this = this;
        _this.hasError = true; 
        if(confirm("Do you really want to delete this user?")){
            axios.post('/vueusers/' +  user.id).then(function (response) {
                _this.getVueUsers();
                _this.successMessage = 'Succesfully deleted user!';
                _this.successAction = false;
            });
        }
    }
  }
});

