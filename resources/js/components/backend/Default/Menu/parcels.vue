<template>
    <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Parcel
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" v-can="['add_parcel']">
                 <router-link :to="{name:'add_parcel'}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Add Parcel</p>
                </router-link>
              </li>
              <!-- <li class="nav-item">
                 <router-link to="/merchant_parcel_list" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Merchant Parcel list</p>
                </router-link>
              </li> -->
              <!-- <li class="nav-item">
                <router-link to="/pending_parcels" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Pending Parcel List</p>
                </router-link>
              </li> -->
              <li class="nav-item" v-can="['all_parcels']">
                <router-link :to="{name:'all_parcels'}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Parcel List</p>
                </router-link>
              </li>
              <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivery in Progress</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivered</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hold</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Returning</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rejected Parcel</p>
                </a>
              </li> -->
            </ul>
          </li>
</template>
