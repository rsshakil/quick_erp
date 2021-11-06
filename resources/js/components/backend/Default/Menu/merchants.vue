<template>
<li class="nav-item" v-role="['Payra Admin']">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Merchants
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" v-role="['Payra Admin']">
              <li class="nav-item" v-can="['add-merchant']">
                <router-link to="/merchants/create" v-bind:active-class="$route.path ===
'/merchants/create'?'active':''" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p> Add Merchants</p>
                </router-link>
              </li>
              <li class="nav-item" v-can="['merchants']">
                <router-link to="/merchants" v-bind:active-class="$route.path ===
'/merchants'?'active':''" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p> All Merchants</p>
                </router-link>
              </li>
              <li class="nav-item" v-can="['all_shops']">
                <router-link to="/all_shops" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>All Shops</p>
                </router-link>
              </li>
            </ul>
          </li>
          </template>
