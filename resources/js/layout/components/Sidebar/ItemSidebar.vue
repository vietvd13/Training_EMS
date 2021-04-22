<template>
  <div>
    <li v-for="(item, index) in items" :key="index">
      <div v-if="item.hasChildren == false">
        <router-link :to="item.path">
          <i :class="item.icon" />
          <span>{{ $t(item.name) }}</span>
        </router-link>
      </div>

      <div v-if="item.hasChildren == true">
        <a v-b-toggle="'collapse-'+index" href="#" @click.prevent>
          <i :class="item.icon" />
          {{ $t(item.name) }}
          <span class="caret float-right when-opened">
            <i class="icofont-caret-up" />
          </span>

          <span class="caret float-right when-closed">
            <i class="icofont-caret-down" />
          </span>
        </a>
        <b-collapse :id="'collapse-' + index">
          <ul :id="'collapse-' + index" class="childrenRoute">
            <li v-for="(children, indexChildren) in item.children" :key="indexChildren">
              <router-link :to="children.path">
                <i :class="children.icon" />
                <span>{{ $t(children.name) }}</span>
              </router-link>
            </li>
          </ul>
        </b-collapse>
      </div>

    </li>

  </div>
</template>

<script>
export default {
  data() {
    return {
      items: [],
    };
  },
  computed: {
    routes() {
      return this.$store.state.permission.routes;
    },
  },
  created() {
    // Get all routes in sotore
    this.$store.state.permission.routes.forEach(route => {
      // Check route hidden
      if (!route.hidden) {
        // Check routes has many children
        if (route.children) {
          // Get nest router (route father)
          var isNest = route.path;

          // If children = 1 => children = main
          if (route.children.length === 1) {
            // Check children is hidden or not => If not push to routes
            if (route.children.hidden !== true) {
              this.items.push({
                path: `${isNest}/${route.children[0].path}`,
                name: route.children[0].meta.title,
                icon: route.children[0].meta.icon,
                hasChildren: false,
              });
            }
          } else {
            // If children > 1 => push routes

            var newchildren = [];

            // Loop to get all children
            route.children.forEach((children) => {
              if (!children.hidden) {
                newchildren.push({
                  path: `${isNest}/${children.path}`,
                  name: children.meta.title,
                  icon: children.meta.icon,
                });
              }
            });

            this.items.push({
              path: route.path,
              name: route.meta.title,
              icon: route.meta.icon,
              hasChildren: true,
              children: newchildren,
            });
          }
        } else {
          this.items.push({
            path: route.path,
            name: route.meta.title,
            icon: route.meta.icon,
            hasChildren: false,
          });
        }
      }
    });
  },
};
</script>

<style scoped>
a {
    text-decoration: none;
    color: #ffffff;
    display: block;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 10px;
    padding-right: 10px;
}

a:hover {
    text-decoration: none;
    color: #ffffff;
    display: block;
}

ul {
    padding-inline-start: 20px;
}

ul li  {
    width: 100%;
    overflow: hidden;
}

ul li a > i {
    padding-right: 10px;
}

ul.childrenRoute {
    background-color: #365d81;
}

.collapsed > .when-opened,
:not(.collapsed) > .when-closed {
    display: none;
}
</style>
