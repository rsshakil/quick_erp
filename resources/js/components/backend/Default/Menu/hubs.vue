<template>
    <li class="nav-item" v-role="['Payra Admin']">
            <router-link to="/hubs" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Hub Manager
                <i class="fas fa-angle-left right"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/hubs/create" v-bind:active-class="$route.path ===
'/hubs/create'?'active':''" v-can="['add-hubs']" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Hub Manager </p>
                </router-link>
              </li>
              <li class="nav-item" v-can="['hubs']">
                <router-link to="/hubs" v-bind:active-class="$route.path ===
'/hubs'?'active':''" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Hub Manager</p>
                </router-link>
              </li>
              <li class="nav-item" v-can="['hubs']">
                <router-link to="/hub-users" v-bind:active-class="$route.path ===
'/hub-users'?'active':''" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Hub User</p>
                </router-link>
              </li>
              <li class="nav-item" v-can="['hubs']">
                <router-link to="/hub-users/create" v-bind:active-class="$route.path ===
'/hub-users/create'?'active':''" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Hub User</p>
                </router-link>
              </li>
            </ul>
          </li>
</template>
