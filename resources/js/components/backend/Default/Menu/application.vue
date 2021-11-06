<template>
    <li class="nav-item" v-role="['Payra Admin']">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Application
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" v-can="['charge_list']">
                  <router-link to="/charge_list" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Charge List</p>
                </router-link>
              </li>
              <li class="nav-item" v-can="['weight_list']">
                  <router-link to="/weight_list" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Weight List</p>
                </router-link>
              </li>
              <li class="nav-item" v-can="['charge_packages']">
                  <router-link to="/charge_packages" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Charge Packages</p>
                </router-link>
              </li>
              <li class="nav-item" v-can="['delivery_options']">
                  <router-link to="/delivery_options" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Delivery Options</p>
                </router-link>
              </li>
            </ul>
          </li>
</template>
