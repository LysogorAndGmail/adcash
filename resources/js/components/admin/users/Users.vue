<template>


    <div class="tab-content responsive">
        <div class="tab-pane active">
            <div class="row mt-2 mb-2">
                <div class="col-md-7">
                    <input type="text" v-model="filter_term" class="form-control" :placeholder="$t('filter_by_name')">
                </div>
                <div class="col-md-5">
                    <div class="float-right">
                        <router-link :to="{name: 'admin.user.create'}" class="btn btn-secondary"
                                     tag="button">
                            {{ $t("add_new_user") }}
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Full name</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <app-user v-for="(user, index) in filteredUsers"
                              :index="index"
                              :user="user"
                              :key="user.id"
                              @removeUser="removeUser"></app-user>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>


<script>
    import appUser from './TableRow';
    import UserService from '@services/user.service';

    export default {
        data() {
            return {
                users: [],
                filter_term: ''
            };
        },
        computed: {
            filteredUsers() {
                return this.users.filter(el => {
                    if (!el.full_name) {
                        return false;
                    }
                    return (el.full_name).toLowerCase().match((this.filter_term).toLowerCase());
                });
            },
            permissions() {
                return this.$store.getters.getUserPermissions;
            }
        },
        methods: {
            fetchUsers() {
                UserService.getUsers().then(users => {
                    this.users = users;
                })
            },
            removeUser(index) {
                this.users.splice(index, 1);
            }
        },
        components: {
            appUser
        },
        created() {
            this.fetchUsers();
        }
    }
</script>
