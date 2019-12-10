<template>
    <section id="content">
        <div class="container">
            <div class="element-header row align-items-center">
                <div class="col-md-auto mr-auto">
                    <h2>{{ user.fname }} {{ user.lname }}</h2>
                </div>
            </div>
            <div class="element-body">
                <div class="row component-boxes">
                    <div class="col-12">
                        <div class="component-box box-white">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <div class="component-box box-white">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped mt-3">
                                                    <tbody>
                                                    <tr>
                                                        <th>{{ $t("first_name") }}</th>
                                                        <td>{{ user.fname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("last_name") }}</th>
                                                        <td>{{ user.lname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("email") }}</th>
                                                        <td v-if="user.email">
                                                            <a :href="'mailto:'+user.email">
                                                                {{ user.email }}
                                                            </a>
                                                        </td>
                                                        <td v-else>-</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("role") }}</th>
                                                        <td>{{ role.display_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("country") }}</th>
                                                        <td v-if="user.country">
                                                            {{ user.country.name }}
                                                        </td>
                                                        <td v-else>-</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("linked_user") }}</th>
                                                        <td v-if="workforce">
                                                            {{ workforce.fname+ ' ' +workforce.lname }}
                                                        </td>
                                                        <td v-else>-</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <div class="text-center">
                                                <a v-if="permissions.includes('user_update')"
                                                   class="btn btn btn-secondary" href="javascript:void(0)"
                                                   @click="edit()">{{ $t("edit") }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    import UserService from '@services/user.service';

    export default {
        data() {
            return {
                user: {},
                role: {},
                workforce: {},
            }
        },
        computed: {
            permissions() {
                return this.$store.getters.getUserPermissions;
            }
        },
        methods: {
            edit() {
                this.$router.push({
                    name: 'user.edit',
                    params: {
                        user_id: this.user.id
                    }
                })
            },
            fetchUser() {
                UserService.getUser(this.$route.params.user_id).then(user => {
                    this.user = user.user;
                    this.role = user.roles[0];
                    this.workforce = user.user.workforce;
                })
            }
        },
        created() {
            this.fetchUser();
        }
    }
</script>
