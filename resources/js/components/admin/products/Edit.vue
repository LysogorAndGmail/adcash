<template>
    <div class="tab-content">
        <div class="tab-pane active">
            <h4 class="mt-2 mb-2">{{ $t("edit") }} {{ job_title.name }}</h4>
            <div class="form-group">
                <label>{{ $t("name") }} *</label>
                <input type="text"
                       v-model="job_title.name"
                       data-vv-name="name"
                       data-vv-as="Name"
                       :class="{'form-control': true, 'is-invalid': errors.has('name') }"
                       v-validate="'required'">
                <span class="invalid-feedback" role="alert" v-show="errors.has('name')">
                    <strong>Name field is required</strong>
                </span>
            </div>
            <div class="form-group">
                <label>{{ $t("category") }} *</label>
                <app-multiselect v-model="selected_category"
                                 label="name"
                                 :placeholder="$t('choose')"
                                 :selectLabel="$t('press_enter_to_select')"
                                 :deselectLabel="$t('press_enter_to_remove')"
                                 :selectedLabel="$t('selected')"
                                 :options="categories"
                                 :allow-empty="false">
                    <template slot="noOptions" slot-scope="props">
                        {{ $t("list_is_empty") }}
                    </template>
                </app-multiselect>
            </div>
            <div class="form-group">
                <button class="btn btn-secondary" @click="update">{{ $t("update") }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    import appMultiselect from 'vue-multiselect';

    export default {
        data() {
            return {
                form: {},
                job_title: {},
                categories: [],
                selected_category: {}
            };
        },
        methods: {
            fetchJobTitle() {
                this.$validator.validate().then(isValid => {
                    if (isValid) {
                        axios.get('/admin/job-title/' + this.$route.params.job_title_id + '/show').then(res => {
                            this.job_title = res.data;
                            this.selected_category = res.data.category;
                        }).catch(error => console.log(error));
                    }
                });
            },
            prepareForm() {
                this.form = {
                    name: this.job_title.name,
                    category_id: this.selected_category.id
                }
            },
            update() {
                this.$validator.validate().then(isValid => {
                    if (isValid) {
                        this.prepareForm();
                        axios.put('/admin/job-title/' + this.$route.params.job_title_id + '/update', this.form).then(res => {
                            this.$toastr.s(this.$t("updated"));
                            this.$router.push({name: 'admin.settings.job.titles'});
                        }).catch(error => console.log(error));
                    }
                });
            },
            fetchJobTitleCategories() {
                axios.get('/admin/job-title-categories').then(res => {
                    this.categories = res.data;
                }).catch(error => console.log(error));
            }
        },
        components: {
            appMultiselect
        },
        created() {
            this.fetchJobTitle();
            this.fetchJobTitleCategories();
        }
    }
</script>
