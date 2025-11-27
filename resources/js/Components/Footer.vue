<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const isRouteActive = (route) => {
    return page.url.includes(route);
};
</script>
<template lang="">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul
                        class="d-flex justify-content-center align-items-center"
                    >
                        <li
                            :class="isRouteActive('production') ? 'active' : ''"
                        >
                            <Link :href="route('production.index')">
                                <i class="fas fa-utensils fa-2xl"></i>
                                <span>Produzione</span>
                            </Link>
                        </li>
                        <li
                            :class="isRouteActive('/warehouse') ? 'active' : ''"
                        >
                            <Link to="/warehouse">
                                <i class="fa-solid fa-warehouse fa-2xl"></i>
                                <span>Magazzino</span>
                            </Link>
                        </li>
                        <li :class="isRouteActive('/calendar') ? 'active' : ''">
                            <Link to="/calendar">
                                <i class="fa-solid fa-calendar-days fa-2xl"></i>
                                <span>Calendario</span>
                            </Link>
                        </li>
                        <li
                            :class="
                                isRouteActive('/administration') ? 'active' : ''
                            "
                        >
                            <Link :href="route('admin.administration.index')">
                                <i class="fas fa-gear fa-2xl"></i>
                                <span>Amministrazione</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;

footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    border-top: 1px solid #c7c7c7;
    background-color: #fff;
    z-index: 80;
    li {
        padding: 20px;
        text-align: center;

        &.active {
            border-top: 3px solid $mainBlue;

            a {
                color: $mainBlue;
            }
        }

        a {
            color: grey;
        }
        span {
            display: block;
            padding-top: 10px;
        }
    }
}
</style>
