<template>
    <section id="content">
        <div class="container">
            <div class="element-header row align-items-center">
                <div class="col-md-auto mr-auto">
                    <h2>{{ $t("add_new_user") }}</h2>
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
                                        <button class="btn btn-secondary" @click="store">{{ $t("save") }}</button>
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
                countries: [],
                selected_country: [],
                roles: []
            }
        },
        methods: {
            store() {
                this.$validator.validate().then(isValid => {
                    if (isValid) {
                        UserService.storeUser(this.form).then(res => {
                            this.$toastr.s(this.$t("saved"));
                            this.$router.push({name: 'admin.users'});
                        })
                    }
                });
            },
        },
        created() {
        }
    }
</script>