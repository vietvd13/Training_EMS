<template>
  <div>
    <b-row>
      <b-col>
        <div class="card">
          <div class="card-body header-dashboard">
            <b-row>
              <b-col>
                <div class="header--userName">
                  <h2>{{ $t('views.dashboard.wellcome', { name: userName }) }}</h2>
                </div>
                <div class="header--email">
                  <p>{{ $t('views.dashboard.email', { email: email }) }}</p>
                  <p>{{ $t('views.dashboard.role', { role: role }) }}</p>
                </div>
              </b-col>
              <b-col class="header-img">
                <div>
                  <img :src="wellcome" alt="Wellcome back">
                </div>
              </b-col>
            </b-row>
          </div>
        </div>
      </b-col>

      <b-col>
        <div class="card">
          <div class="card-body header-dashboard">
            <b-col>
              <b-row>
                <div class="header-time">
                  <div v-if="hourtime != ''">
                    <p>{{ hours }} : {{ minutes }} <i :class="getIconHourTime(hourtime)" /></p>
                  </div>
                </div>
              </b-row>

              <b-row>
                <div class="header-quotes">
                  <span>{{ $t('views.dashboard.quotes') }}</span>
                </div>
              </b-row>
            </b-col>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
// Import funcotion helper
import { SECOND, HOUR, getHourTime, getZeroPad } from './helper/Filters';
// Import img
const wellcome = require('@/assets/images/wellcome.png');

export default {
  name: 'HeaderDashboard',
  data() {
    const fullName = this.$store.getters.name;
    const email = this.$store.getters.email;
    const role = this.$store.getters.roles[0];

    return {
      // Information user
      userName: fullName,
      email: email,
      role: role,
      wellcome: wellcome,

      // Add ons
      hours: 0,
      minutes: 0,
      seconds: 0,
      hourtime: '',
    };
  },
  mounted() {
    this.$options.timer = window.setTimeout(this.updateDateTime, SECOND);
  },
  beforeDestroy() {
    window.clearTimeout(this.$options.timer);
  },
  methods: {
    updateDateTime() {
      const now = new Date();
      this.hours = now.getHours();
      this.minutes = getZeroPad(now.getMinutes());
      this.seconds = getZeroPad(now.getSeconds());
      this.hourtime = getHourTime(this.hours);
      this.hours = this.hours % HOUR || HOUR;
      this.$options.timer = window.setTimeout(this.updateDateTime, SECOND);
    },
    getIconHourTime(hourtime) {
      switch (hourtime) {
        case 'AM':
          return 'icofont-full-sunny';
        case 'PM':
          return 'icofont-full-night';
        default:
          return 'icofont-full-sunny';
      }
    },
  },
};
</script>

<style lang="scss" scoped>
    @media screen and (max-width: 1275px) {
        .header--userName {
            margin-top: 20px;
            justify-content: space-around;
        }

        .header--email {
            margin: 0 auto;
            margin-top: auto;
            margin-bottom: auto;
            width: 100%;
            margin-top: 20px;
            p {
                text-align: center;
                justify-content: space-around;
            }
        }

        .header-img {
            display: none;
        }

        .header-quotes {
            display: none;
        }

        .header-time {
            height: 100%;
            overflow: hidden;

            p {
                height: 110px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }
    }

    .header-dashboard {
        min-height: 200px;
        max-height: 330px;

        img {
            width: auto;
            height: 160px;
            display: block;
            float: right;
        }

        .header--userName {
            display: flex;
            align-items: center;
            color: #303133;
        }

        .header--email {
            display: flex;
            align-items: center;
            display: inline-block;

            p {
                margin: 0;
                color: #606266;
            }
        }

        .header-time {
            height: 80%;
            width: 100%;
            overflow: hidden;
            text-align: center;

            p {
                font-size: 40px;
                margin-top: 25px;
                margin-bottom: 25px;
            }
        }

        .header-quotes {
            height: 20%;
            width: 100%;
            overflow: hidden;
            text-align: center;
        }
    }
</style>
