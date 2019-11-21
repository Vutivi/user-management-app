<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Vue.js CRUD - Just Laravel</title>

<!-- Fonts -->
<link rel="stylesheet"
    href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- Styles -->
<style>
html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Raleway', sans-serif;
    font-weight: 100;
    height: auto;
    margin: 0;
}
.full-height {
    min-height: 100vh;
}
.flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
}
.position-ref {
    position: relative;
}
.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}
.content {
/*  text-align: center; */
}
.title {
    font-size: 84px;
}
.m-b-md {
    margin-bottom: 30px;
}
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}
.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}
.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}
.modal-body {
  margin: 20px 0;
}

.mat-cell {
        font-size: 14px;
        min-height: 48px;
        text-align: center;
        border-right: 1px solid black;
    }
</style>
</head>
<body>
    <div class="flex-center position-ref full-height">
        <div id="vue-wrapper">
            <div class="content">
                <!-- <div class="form-group row"> -->
                    <!-- <div class="col-md-8"> -->
                
                <a id="show-create-modal" @click="showCreateModal=true;" class="btn btn-primary" >Create user</a>
                <br /><br />
                <p class="text-center alert alert-success"
                    v-bind:class="{ hidden: successAction }">@{{successMessage}}</p>
                <div class="mdc-data-table">
                    <table class="mdc-data-table__table mat-cell" aria-label="Dessert calories">
                        <thead>
                            <tr class="mdc-data-table__header-row">
                                <th class="mdc-data-table__header-cell mat-cell" role="columnheader" scope="col">ID</th>
                                <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric mat-cell" role="columnheader" scope="col">First name</th>
                                <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric mat-cell" role="columnheader" scope="col">Last name</th>
                                <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric mat-cell" role="columnheader" scope="col">Email</th>
                                <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric mat-cell" role="columnheader" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="mdc-data-table__content">
                            <tr class="mdc-data-table__row mat-cell" v-for="user in users">
                                <td class="mdc-data-table__cell mat-cell">@{{ user.id }}</td>
                                <td class="mdc-data-table__cell mat-cell">@{{ user.first_name }}</td>
                                <td class="mdc-data-table__cell mat-cell">@{{ user.surname }}</td>
                                <td class="mdc-data-table__cell mat-cell">@{{ user.email }}</td>
                                <td class="mdc-data-table__cell mat-cell">
                                    <a id="show-edit-modal" @click="showEditModal=true; setVal(user.id, user.first_name, user.surname, user.email, user.username, user.password)"  class="btn btn-info" ><span
                                        class="glyphicon glyphicon-pencil"></span></a>
                                        <a @click.prevent="deleteUser(user)" class="btn btn-danger"><span
                                            class="glyphicon glyphicon-trash"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <modal v-if="showEditModal" @close="showEditModal=false" id="edit">
                    <h3 slot="header">Edit User</h3>
                    <div slot="body">
                        
                        <input type="hidden" disabled class="form-control" id="e_id" name="id"
                                required  :value="this.e_id">
                        First name: <input type="text" class="form-control" id="e_first_name" name="first_name"
                                required  :value="this.e_first_name">
                        Last name: <input type="text" class="form-control" id="e_surname" name="surname"
                        required  :value="this.e_surname">
                        Email: <input type="text" class="form-control" id="e_email" name="email"
                                required  :value="this.e_email">
                        Username: <input type="text" class="form-control" id="e_username" name="username"
                        required  :value="this.e_username">

                        Password: <input type="password" class="form-control" id="e_password" name="password"
                                placeholder="Enter old or new password" required  :value="this.e_password">

        
                      
                    </div>
                    <div slot="footer">
                        <button class="btn btn-default" @click="showEditModal = false">
                        Cancel
                      </button>
                      
                      <button class="btn btn-info" @click="editUser()">
                        Update
                      </button>
                    </div>
                </modal>

                <modal v-if="showCreateModal" @close="showCreateModal=false" id="create">
                    <h3 slot="header">Create User</h3>
                    <div slot="body">     
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" 
                                required v-model="newUser.first_name" placeholder="Enter first name">
                        </div>

                        <div class="form-group">
                            <label for="surname">Last name</label>
                            <input type="text" class="form-control" id="surname" name="surname" 
                                required v-model="newUser.surname" placeholder="Enter last name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" 
                                required v-model="newUser.email" placeholder="Enter your email">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                required v-model="newUser.username" placeholder="Enter your username">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                required v-model="newUser.password" placeholder="Enter your password">
                        </div>

                        <p class="text-center alert alert-danger"
                            v-bind:class="{ hidden: hasError }">Please fill all fields!</p>
                        {{ csrf_field() }}
                        <div slot="footer">
                        <button class="btn btn-default" @click="showCreateModal = false">
                        Cancel
                      </button>
                      
                        <button class="btn btn-primary" @click.prevent="createUser()" id="name" name="name">
                            <span class="glyphicon glyphicon-plus"></span> Create user
                        </button>
                    </div>
                </modal>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>
    <script type="text/x-template" id="modal-template">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header">
                  default header
                </slot>
              </div>

              <div class="modal-body">
                <slot name="body">
                    
                </slot>
              </div>

              <div class="modal-footer">
                <slot name="footer">
                  
                  
                </slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </script>
</body>
</html>