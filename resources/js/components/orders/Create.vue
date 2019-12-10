<template>
    <section id="content">
        <div class="container">
            <div class="element-header row align-items-center">
                <div class="col-md-auto mr-auto">
                    <h2>{{ $t("add_new_workforce") }}</h2>
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
                                                <label>{{ $t("job_title") }} *</label>
                                                <app-multiselect
                                                        data-vv-name="JobTitle"
                                                        data-vv-as="Job Title"
                                                        v-validate="'required'"
                                                        autocomplete="off"
                                                        v-model="selected_job_title"
                                                        label="name"
                                                        :options="job_titles"
                                                        @update="selectedJT"
                                                        track-by="name"
                                                        :placeholder="$t('choose')"
                                                        :selectLabel="$t('press_enter_to_select')"
                                                        :deselectLabel="$t('press_enter_to_remove')"
                                                        :selectedLabel="$t('selected')"
                                                        :allow-empty="false">
                                                    <template slot="noOptions" slot-scope="props">
                                                        {{ $t("list_is_empty") }}
                                                    </template>
                                                </app-multiselect>
                                                <span v-show="errors.has('JobTitle')"
                                                      class="help is-danger validation_error" role="alert">
                                                    <strong>{{ errors.first('JobTitle') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("first_name") }} *</label>
                                                <input type="text" class="form-control" v-model="form.fname"
                                                       data-vv-name="fname"
                                                       data-vv-as="First Name"
                                                       :class="{'is-invalid': errors.has('fname') }"
                                                       v-validate="'required'">
                                                <span class="invalid-feedback" role="alert"
                                                      v-show="errors.has('fname')">
                                                   <strong>{{ errors.first('fname') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("last_name") }} *</label>
                                                <input type="text" class="form-control" v-model="form.lname"
                                                       data-vv-name="lname"
                                                       data-vv-as="Last Name"
                                                       :class="{'is-invalid': errors.has('lname') }"
                                                       v-validate="'required'">
                                                <span class="invalid-feedback" role="alert"
                                                      v-show="errors.has('lname')">
                                                  <strong>{{ errors.first('lname') }}</strong>
                                               </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("phone") }} *</label>
                                                <input type="text" class="form-control" v-model="form.phone"
                                                       data-vv-name="phone"
                                                       data-vv-as="Phone"
                                                       :class="{'is-invalid': errors.has('phone') }"
                                                       v-validate="'required'">
                                                <span class="invalid-feedback" role="alert"
                                                      v-show="errors.has('phone')">
                                                    <strong>{{ errors.first('phone') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("email") }} *</label>
                                                <input type="email" class="form-control" v-model="form.email"
                                                       data-vv-name="email"
                                                       data-vv-as="Email"
                                                       :class="{'is-invalid': errors.has('email') }"
                                                       v-validate="'required|email'">
                                                <span class="invalid-feedback" role="alert"
                                                      v-show="errors.has('email')">
                                                    <strong>{{ errors.first('email') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("dob") }} *</label>
                                                <datepicker v-model="form.dob" input-class="form-control"
                                                            format="dd.MM.yyyy"
                                                            :monday-first="true"
                                                            @selected="DOBChange"
                                                            data-vv-name="dob"
                                                            data-vv-as="DOB"
                                                            v-validate="'required'"
                                                            :bootstrap-styling="true"
                                                            :class="{'bg-white':true}">
                                                </datepicker>
                                                <span v-show="errors.has('dob')" class="help is-danger validation_error"
                                                      role="alert">
                                                    <strong>{{ errors.first('dob') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("address") }}</label>
                                                <input type="text" class="form-control" v-model="form.address">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("bank_account") }}</label>
                                                <input type="text" class="form-control" v-model="form.bank_acc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("id_code") }}</label>
                                                <input type="text" class="form-control" v-model="form.idcode">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("recruited_by") }}</label>
                                                <app-multiselect v-model="selected_recruited"
                                                                 label="full_name"
                                                                 autocomplete="off"
                                                                 :options="organization_users"
                                                                 track-by="full_name"
                                                                 :placeholder="$t('choose')"
                                                                 :selectLabel="$t('press_enter_to_select')"
                                                                 :deselectLabel="$t('press_enter_to_remove')"
                                                                 :selectedLabel="$t('selected')"
                                                                 :allow-empty="true">
                                                    <template slot="noOptions" slot-scope="props">
                                                        {{ $t("list_is_empty") }}
                                                    </template>
                                                </app-multiselect>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>{{ $t("linked_user") }}</label>
                                                <app-multiselect v-model="selected_linked_user"
                                                                 label="full_name"
                                                                 autocomplete="off"
                                                                 :options="organization_users"
                                                                 track-by="full_name"
                                                                 :placeholder="$t('choose')"
                                                                 :selectLabel="$t('press_enter_to_select')"
                                                                 :deselectLabel="$t('press_enter_to_remove')"
                                                                 :selectedLabel="$t('selected')"
                                                                 :allow-empty="true">
                                                    <template slot="noOptions" slot-scope="props">
                                                        {{ $t("list_is_empty") }}
                                                    </template>
                                                </app-multiselect>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>{{ $t("is_personnel") }}</label><br/>
                                                        <toggle-button v-model="form.is_personnel" :width="80"
                                                                       class="filter-button"
                                                                       :color="{checked: '#5ec58c', unchecked: '#bec7dd'}"
                                                                       :labels="{checked: $t('yes'), unchecked: $t('no')}"/>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>{{ $t("gender") }}</label><br/>
                                                        <toggle-button v-model="form.gender" :width="80"
                                                                       class="filter-button"
                                                                       :color="{checked: '#FFC0CB', unchecked: '#6666ff'}"
                                                                       :labels="{checked: $t('female'), unchecked: $t('male')}"/>
                                                    </div>
                                                </div>
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
    import appMultiselect from 'vue-multiselect';
    import Datepicker from 'vuejs-datepicker';

    export default {
        data() {
            return {
                form: {},
                workforce_job_title: {},
                job_titles: [],
                selected_job_title: [],
                organization_users: [],
                selected_recruited: {},
                selected_linked_user: {},
                DOB_required: '',
            }
        },
        methods: {
            store() {
                this.$validator.validate().then(isValid => {
                    if (isValid) {
                        this.prepareForm();
                        axios.post('/workforce/store', this.form).then(res => {
                            this.$toastr.s(this.$t("saved"));
                            this.$router.push({name: 'workforces'});
                        }).catch(error => console.log(error));
                    }
                });
            },
            selectedJT(selected) {
                this.selected_job_title = selected;
            },
            DOBChange() {
                this.DOB_required = 'text';

            },
            userChange() {
                this.user_required = 'text';
            },
            prepareForm() {
                this.form = {
                    job_title_id: this.selected_job_title.id,
                    user_id: this.selected_linked_user.id,
                    fname: this.form.fname,
                    lname: this.form.lname,
                    gender: this.form.gender,
                    dob: this.form.dob,
                    is_personnel: this.form.is_personnel,
                    phone: this.form.phone,
                    email: this.form.email,
                    recruited_by: this.selected_recruited.id,
                    address: this.form.address,
                    bank_acc: this.form.bank_acc,
                    idcode: this.form.idcode,

                }
            },
            fetchJobTitles() {
                axios.get('/admin/job-titles').then(res => {
                    this.job_titles = res.data;
                }).catch(error => console.log(error));
            },
            fetchOrganizationUsers() {
                axios.get('/organization-users').then(res => {
                    this.organization_users = res.data;
                }).catch(error => console.log(error));
            }
        },
        components: {
            appMultiselect,
            Datepicker
        },
        created() {
            this.fetchJobTitles();
            this.fetchOrganizationUsers();
            this.form.gender = false;
            this.form.is_personnel = false;
        }
    }
</script>

<style>
    .validation_error {
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }

    .bg-white > div > input {
        background-color: white !important;
    }
</style>