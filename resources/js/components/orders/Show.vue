<template>
    <section id="content">
        <div class="container">
            <div class="element-header row align-items-center">
                <div class="col-md-auto mr-auto">
                    <h2>{{ job_titles.name }}</h2>
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
                                                        <th>{{ $t("organization") }}</th>
                                                        <td>{{ organization.name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("job_title") }}</th>
                                                        <td>{{ job_titles.name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("first_name") }}</th>
                                                        <td>{{ workforce.fname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("last_name") }}</th>
                                                        <td>{{ workforce.lname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("email") }}</th>
                                                        <td v-if="workforce.email">
                                                            <a :href="'mailto:'+workforce.email">
                                                                {{ workforce.email }}
                                                            </a>
                                                        </td>
                                                        <td v-else>-</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("phone") }}</th>
                                                        <td>{{ workforce.phone }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("address") }}</th>
                                                        <td>{{ workforce.address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("linked_user") }}</th>
                                                        <td v-if="workforce.user_id">
                                                            <router-link :to="{name: 'user.show', params:{user_id:user.id}}" tag="a">
                                                                {{ user.fname }} {{ user.lname }}
                                                            </router-link>

                                                        </td>
                                                        <td v-else>
                                                            -
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("gender") }}</th>
                                                        <td v-if="workforce.gender == 0">
                                                            {{ $t("male") }}
                                                        </td>
                                                        <td v-else>{{ $t("female") }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("dob") }}</th>
                                                        <td>{{ workforce.dob | formatDate }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Is personnel</th>
                                                        <td v-if="workforce.is_personnel == 1">
                                                            {{ $t("personnel") }}
                                                        </td>
                                                        <td v-else>-</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ $t("created_by") }}</th>
                                                        <td>
                                                            {{ created_user.fname }} {{ created_user.lname }} @
                                                            {{ workforce.created_at | formatDate }}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <div class="text-center">
                                                <a v-if="permissions.includes('workforce_update')" class="btn btn btn-secondary" href="javascript:void(0)" @click="edit()">{{ $t("edit") }}</a>
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
    export default {
        data() {
            return {
                workforce: {},
                job_titles: {},
                organization: {},
                user: {},
                created_user: {},
                is_personal: 0,
                gender: 0
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
                    name: 'workforce.edit',
                    params: {
                        workforce_id: this.workforce.id
                    }
                })
            },
            fetchWorkforce() {
                axios.get('/workforce/' + this.$route.params.workforce_id + '/show').then(res => {
                    this.workforce = res.data;
                    this.job_titles = res.data.job_titles;
                    this.organization = res.data.organization;
                    this.user = res.data.user;
                    this.created_user = res.data.created_user;
                }).catch(error => console.log(error));
            }
        },
        created() {
            this.fetchWorkforce();
        }
    }
</script>
