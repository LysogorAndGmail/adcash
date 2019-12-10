<template>
    <section id="content">
        <div class="container">
            <div class="element-header row align-items-center">
                <div class="col-md-auto mr-auto">
                    <h2>{{ $t("edit") }} {{ form.full_name }}</h2>
                </div>
            </div>
            <div class="element-body">
                <div class="row component-boxes">
                    <div class="col-12">
                        <div class="component-box box-white">
                            <div class="component-box-inner">
                                <div class="component-box-profile">
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Full name *</label>
                                                <input type="text" class="form-control" v-model="form.full_name"
                                                       data-vv-name="full_name"
                                                       data-vv-as="Full Name"
                                                       :class="{'is-invalid': errors.has('full_name') }"
                                                       v-validate="'required'">
                                                <span class="invalid-feedback" role="alert"
                                                      v-show="errors.has('full_name')">
                                                   <strong>{{ errors.first('full_name') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <button class="btn btn-secondary" @click="update">{{ $t("update") }}</button>
                                        <router-link
                                                :to="{name: 'admin.users'}"
                                                tag="button" class="btn btn-warning">
                                            {{ $t("cancel") }}
                                        </router-link>
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
                form: {},
            }
        },
        methods: {
            fetchUser() {
                UserService.getUser(this.$route.params.user_id).then(user => {
                    this.form = user;
                })
            },
            update() {
                this.$validator.validate().then(isValid => {
                    if (isValid) {
                        UserService.updateUser(this.$route.params.user_id, this.form).then(res => {
                            this.$toastr.s(this.$t("updated"));
                            this.$router.push({
                                name: 'admin.users'
                            });
                        }).catch(error => console.log(error));
                    }
                });
            }
        },
        components: {
        },
        created() {
            this.fetchUser();
        }
    }
</script>
